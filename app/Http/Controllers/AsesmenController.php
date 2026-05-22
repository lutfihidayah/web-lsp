<?php

namespace App\Http\Controllers;

use App\Models\Asesmen;
use App\Models\Absensi;
use App\Models\Soal;
use App\Models\QuizJawaban;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Services\AsesmenService;

class AsesmenController extends Controller
{
    protected $asesmenService;

    public function __construct(AsesmenService $asesmenService)
    {
        $this->asesmenService = $asesmenService;
    }

    /**
     * Admin/Superadmin/Asesor: monitor semua asesmen | User: asesmen milik sendiri
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'superadmin', 'asesor'])) {
            $query = Asesmen::with(['pendaftaran.skema', 'pendaftaran.user', 'absensi']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('search')) {
                $query->whereHas('pendaftaran.user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            }

            $asesmens         = $query->latest()->paginate(15)->withQueryString();
            $totalBerlangsung = Asesmen::where('status', 'berlangsung')->count();
            $totalLulus       = Asesmen::where('status', 'lulus')->count();
            $totalTidakLulus  = Asesmen::where('status', 'tidak_lulus')->count();

            return view('asesmen.index', compact('asesmens', 'totalBerlangsung', 'totalLulus', 'totalTidakLulus'));
        }

        // User: asesmen milik sendiri
        $asesmens = Asesmen::whereHas('pendaftaran', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['pendaftaran.skema', 'pendaftaran.jadwal', 'absensi'])
            ->latest()
            ->get();

        $totalBerlangsung = $asesmens->where('status', 'berlangsung')->count();
        $totalLulus       = $asesmens->where('status', 'lulus')->count();
        $totalTidakLulus  = $asesmens->where('status', 'tidak_lulus')->count();

        return view('asesmen.index', compact('asesmens', 'totalBerlangsung', 'totalLulus', 'totalTidakLulus'));
    }

    /**
     * Admin/Superadmin/Asesor: detail progress peserta | User: detail asesmen sendiri
     */
    public function show($id)
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'superadmin', 'asesor'])) {
            $asesmen = Asesmen::with([
                'pendaftaran.skema',
                'pendaftaran.user',
                'pendaftaran.jadwal',
                'absensi',
                'quizJawaban.soal',
            ])->findOrFail($id);
        } else {
            $asesmen = Asesmen::whereHas('pendaftaran', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with(['pendaftaran.skema', 'absensi', 'quizJawaban.soal'])
                ->findOrFail($id);
        }

        return view('asesmen.show', compact('asesmen'));
    }

    /**
     * User: konfirmasi hadir pada pertemuan tertentu
     */
    public function hadir($absensiId)
    {
        try {
            $absensi = Absensi::whereHas('asesmen.pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })->findOrFail($absensiId);

            $this->asesmenService->recordSelfPresence($absensi, auth()->id());

            return back()->with('success', 'Kehadiran pertemuan ke-' . $absensi->pertemuan_ke . ' berhasil dicatat! Menunggu konfirmasi admin.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin/Superadmin/Asesor: konfirmasi kehadiran peserta
     */
    public function konfirmasiHadir($absensiId)
    {
        $absensi = Absensi::findOrFail($absensiId);

        try {
            $this->asesmenService->confirmPresence($absensi);
            return back()->with('success', 'Kehadiran pertemuan ke-' . $absensi->pertemuan_ke . ' berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Admin/Superadmin/Asesor: konfirmasi semua kehadiran sekaligus
     */
    public function konfirmasiSemua($asesmenId)
    {
        $asesmen = Asesmen::findOrFail($asesmenId);
        $updated = $this->asesmenService->confirmAllPresence($asesmen);

        return back()->with('success', $updated . ' absensi berhasil dikonfirmasi.');
    }

    /**
     * User: halaman quiz
     */
    public function quiz($asesmenId)
    {
        $user = auth()->user();
        try {
            $asesmen = Asesmen::whereHas('pendaftaran', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with(['pendaftaran.skema'])
                ->findOrFail($asesmenId);

            $soals = $this->asesmenService->getQuizQuestions($asesmen, $user->id);

            return view('quiz.index', compact('asesmen', 'soals'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            return redirect()->route('asesmen.show', $asesmenId)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * User: submit jawaban quiz
     */
    public function submitQuiz(Request $request, $asesmenId)
    {
        $user = auth()->user();
        $request->validate([
            'jawaban'   => 'required|array',
            'jawaban.*' => 'required|in:a,b,c,d',
        ]);

        try {
            $asesmen = Asesmen::whereHas('pendaftaran', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->findOrFail($asesmenId);

            $nilai = $this->asesmenService->submitQuiz($asesmen, $user->id, $request->jawaban);

            return redirect()->route('asesmen.show', $asesmen->id)
                ->with('success', 'Quiz selesai! Nilai Anda: ' . $nilai);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            return redirect()->route('asesmen.show', $asesmenId)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Admin/Superadmin/Asesor: sertifikat peserta manapun | User: sertifikat milik sendiri
     */
    public function sertifikat($asesmenId)
    {
        $user  = auth()->user();
        $query = Asesmen::with(['pendaftaran.skema', 'pendaftaran.user'])
            ->where('status', 'lulus');

        // Admin/Superadmin/Asesor boleh melihat sertifikat peserta manapun untuk keperluan verifikasi atau cetak fisik
        if (!in_array($user->role, ['admin', 'superadmin', 'asesor'])) {
            $query->whereHas('pendaftaran', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $asesmen = $query->findOrFail($asesmenId);

        return view('sertifikat.show', compact('asesmen'));
    }
}
