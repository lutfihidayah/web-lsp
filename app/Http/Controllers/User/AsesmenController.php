<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asesmen;
use App\Models\Absensi;
use App\Models\Soal;
use App\Models\QuizJawaban;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsesmenController extends Controller
{
    /**
     * Dashboard asesmen user — progress absensi + quiz
     */
    public function index()
    {
        $asesmens = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['pendaftaran.skema', 'pendaftaran.jadwal', 'absensi'])
            ->latest()
            ->get();

        return view('user.asesmen', compact('asesmens'));
    }

    /**
     * Detail asesmen tertentu
     */
    public function show($id)
    {
        $asesmen = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['pendaftaran.skema', 'absensi', 'quizJawaban.soal'])
            ->findOrFail($id);

        return view('user.asesmen-detail', compact('asesmen'));
    }

    /**
     * User konfirmasi hadir pada pertemuan tertentu
     */
    public function hadir($absensiId)
    {
        $absensi = Absensi::whereHas('asesmen.pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'belum')
            ->findOrFail($absensiId);

        // Cek apakah tanggal pertemuan sudah sampai (skip jika mode debug/testing)
        if (!config('app.debug') && $absensi->tanggal && $absensi->tanggal->isFuture()) {
            return back()->with('error', 'Pertemuan ini belum dimulai. Tanggal: ' . $absensi->tanggal->format('d M Y'));
        }

        $absensi->update([
            'status' => 'hadir',
            'dikonfirmasi_oleh' => 'user',
        ]);

        return back()->with('success', 'Kehadiran pertemuan ke-' . $absensi->pertemuan_ke . ' berhasil dicatat! Menunggu konfirmasi admin.');
    }

    /**
     * Halaman quiz — tampilkan 10 soal
     */
    public function quiz($asesmenId)
    {
        $asesmen = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['pendaftaran.skema', 'absensi'])
            ->findOrFail($asesmenId);

        // Cek apakah absensi sudah lengkap (semua hadir + dikonfirmasi admin)
        $totalAbsensi = $asesmen->absensi()->count();
        $absensiKonfirmasi = $asesmen->absensi()->where('status', 'hadir')->where('dikonfirmasi_oleh', 'admin')->count();
        if ($absensiKonfirmasi < $totalAbsensi) {
            return redirect()->route('user.asesmen.show', $asesmen->id)
                ->with('error', 'Anda harus menyelesaikan semua pertemuan (' . $totalAbsensi . ' hari) dan dikonfirmasi admin sebelum mengerjakan quiz.');
        }

        // Cek apakah sudah pernah mengerjakan quiz
        if ($asesmen->quizJawaban()->count() > 0) {
            return redirect()->route('user.asesmen.show', $asesmen->id)
                ->with('error', 'Anda sudah mengerjakan quiz ini.');
        }

        $soals = Soal::where('skema_id', $asesmen->pendaftaran->skema_id)
            ->inRandomOrder()
            ->take(10)
            ->get();

        if ($soals->count() < 10) {
            return redirect()->route('user.asesmen.show', $asesmen->id)
                ->with('error', 'Soal quiz belum tersedia untuk skema ini. Hubungi admin.');
        }

        return view('user.quiz', compact('asesmen', 'soals'));
    }

    /**
     * Submit jawaban quiz dan hitung nilai
     */
    public function submitQuiz(Request $request, $asesmenId)
    {
        $asesmen = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with('pendaftaran.skema')
            ->findOrFail($asesmenId);

        // Cek sudah pernah submit
        if ($asesmen->quizJawaban()->count() > 0) {
            return redirect()->route('user.asesmen.show', $asesmen->id)
                ->with('error', 'Anda sudah mengerjakan quiz ini.');
        }

        $request->validate([
            'jawaban' => 'required|array',
            'jawaban.*' => 'required|in:a,b,c,d',
        ]);

        DB::transaction(function () use ($request, $asesmen) {
            $benarCount = 0;

            foreach ($request->jawaban as $soalId => $jawaban) {
                $soal = Soal::find($soalId);
                if (!$soal) continue;

                $isBenar = $jawaban === $soal->jawaban_benar;
                if ($isBenar) $benarCount++;

                QuizJawaban::create([
                    'asesmen_id' => $asesmen->id,
                    'soal_id' => $soalId,
                    'jawaban_user' => $jawaban,
                    'is_benar' => $isBenar,
                ]);
            }

            $totalSoal = count($request->jawaban);
            $nilai = ($benarCount / $totalSoal) * 100;

            if ($nilai >= 60) {
                $noSertifikat = 'LSP-' . date('Ym') . '-' . str_pad($asesmen->id, 4, '0', STR_PAD_LEFT);
                $asesmen->update([
                    'status' => 'lulus',
                    'nilai_quiz' => $nilai,
                    'no_sertifikat' => $noSertifikat,
                    'sertifikat_dibuat_at' => now(),
                ]);
            } else {
                $asesmen->update([
                    'status' => 'tidak_lulus',
                    'nilai_quiz' => $nilai,
                ]);
            }
        });

        return redirect()->route('user.asesmen.show', $asesmen->id)
            ->with('success', 'Quiz selesai! Nilai Anda: ' . $asesmen->fresh()->nilai_quiz);
    }

    /**
     * Download sertifikat
     */
    public function sertifikat($asesmenId)
    {
        $asesmen = Asesmen::whereHas('pendaftaran', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->with(['pendaftaran.skema', 'pendaftaran.user'])
            ->where('status', 'lulus')
            ->findOrFail($asesmenId);

        return view('user.sertifikat', compact('asesmen'));
    }
}
