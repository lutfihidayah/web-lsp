<?php

namespace App\Services;

use App\Models\Asesmen;
use App\Models\Absensi;
use App\Models\Soal;
use App\Models\QuizJawaban;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AsesmenService
{
    /**
     * Record candidate self attendance for a meeting.
     *
     * @param Absensi $absensi
     * @param int $userId
     * @throws \Exception
     */
    public function recordSelfPresence(Absensi $absensi, int $userId): void
    {
        if ($absensi->asesmen->pendaftaran->user_id !== $userId) {
            throw new \Exception('Unauthorized attendance recording.');
        }

        if ($absensi->status !== 'belum') {
            throw new \Exception('Kehadiran sudah tercatat sebelumnya.');
        }

        if (!config('app.debug') && $absensi->tanggal && Carbon::parse($absensi->tanggal)->isFuture()) {
            throw new \Exception('Pertemuan ini belum dimulai. Tanggal: ' . Carbon::parse($absensi->tanggal)->format('d M Y'));
        }

        $absensi->update([
            'status'            => 'hadir',
            'dikonfirmasi_oleh' => 'user',
        ]);
    }

    /**
     * Admin/Asesor confirms participant attendance.
     *
     * @param Absensi $absensi
     * @throws \Exception
     */
    public function confirmPresence(Absensi $absensi): void
    {
        if ($absensi->status !== 'hadir') {
            throw new \Exception('Peserta belum menandai kehadiran untuk pertemuan ini.');
        }

        $absensi->update([
            'dikonfirmasi_oleh' => 'admin',
        ]);
    }

    /**
     * Admin/Asesor confirms all pending attendances for a specific assessment.
     *
     * @param Asesmen $asesmen
     * @return int Number of updated rows
     */
    public function confirmAllPresence(Asesmen $asesmen): int
    {
        return $asesmen->absensi()
            ->where('status', 'hadir')
            ->where(function ($q) {
                $q->whereNull('dikonfirmasi_oleh')
                  ->orWhere('dikonfirmasi_oleh', 'user');
            })
            ->update(['dikonfirmasi_oleh' => 'admin']);
    }

    /**
     * Validate quiz prerequisites and return random questions.
     *
     * @param Asesmen $asesmen
     * @param int $userId
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    public function getQuizQuestions(Asesmen $asesmen, int $userId): \Illuminate\Support\Collection
    {
        if ($asesmen->pendaftaran->user_id !== $userId) {
            throw new \Exception('Unauthorized quiz access.');
        }

        $totalAbsensi      = $asesmen->absensi()->count();
        $absensiKonfirmasi = $asesmen->absensi()->where('status', 'hadir')->where('dikonfirmasi_oleh', 'admin')->count();

        if ($absensiKonfirmasi < $totalAbsensi) {
            throw new \Exception('Anda harus menyelesaikan semua pertemuan (' . $totalAbsensi . ' hari) dan dikonfirmasi admin sebelum mengerjakan quiz.');
        }

        if ($asesmen->quizJawaban()->count() > 0) {
            throw new \Exception('Anda sudah mengerjakan quiz ini.');
        }

        $soals = Soal::where('skema_id', $asesmen->pendaftaran->skema_id)
            ->inRandomOrder()
            ->take(10)
            ->get();

        if ($soals->count() < 10) {
            throw new \Exception('Soal quiz belum tersedia untuk skema ini. Hubungi admin.');
        }

        return $soals;
    }

    /**
     * Submit user's quiz answers, grade the quiz, and generate certificates for passing candidates.
     *
     * @param Asesmen $asesmen
     * @param int $userId
     * @param array $jawaban
     * @return float Score
     * @throws \Exception
     */
    public function submitQuiz(Asesmen $asesmen, int $userId, array $jawaban): float
    {
        if ($asesmen->pendaftaran->user_id !== $userId) {
            throw new \Exception('Unauthorized quiz submission.');
        }

        if ($asesmen->quizJawaban()->count() > 0) {
            throw new \Exception('Anda sudah mengerjakan quiz ini.');
        }

        return DB::transaction(function () use ($asesmen, $jawaban) {
            $benarCount = 0;
            $soalIds = array_keys($jawaban);
            $soals   = Soal::whereIn('id', $soalIds)->get()->keyBy('id');

            foreach ($jawaban as $soalId => $ans) {
                $soal = $soals->get($soalId);
                if (!$soal) continue;

                $isBenar = $ans === $soal->jawaban_benar;
                if ($isBenar) {
                    $benarCount++;
                }

                QuizJawaban::create([
                    'asesmen_id'   => $asesmen->id,
                    'soal_id'      => $soalId,
                    'jawaban_user' => $ans,
                    'is_benar'     => $isBenar,
                ]);
            }

            $totalSoal    = count($jawaban);
            $nilai        = ($benarCount / $totalSoal) * 100;
            $passingGrade = $asesmen->pendaftaran->skema->passing_grade ?? 60;

            if ($nilai >= $passingGrade) {
                $noSertifikat = 'LSP-' . date('Ym') . '-' . str_pad($asesmen->id, 4, '0', STR_PAD_LEFT);
                $asesmen->update([
                    'status'               => 'lulus',
                    'nilai_quiz'           => $nilai,
                    'no_sertifikat'        => $noSertifikat,
                    'sertifikat_dibuat_at' => now(),
                ]);
            } else {
                $asesmen->update([
                    'status'     => 'tidak_lulus',
                    'nilai_quiz' => $nilai,
                ]);
            }

            return $nilai;
        });
    }
}
