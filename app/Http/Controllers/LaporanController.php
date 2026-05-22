<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendaftaran;
use App\Models\Asesmen;
use App\Models\Jadwal;
use App\Models\Skema;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $skemas = Skema::latest()->get();
        $type = $request->input('type', 'peserta');
        $status = $request->input('status');
        $skemaId = $request->input('skema_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = collect();
        $summary = [];

        if ($type === 'peserta') {
            $query = User::where('role', 'user');
            if ($status) {
                $query->where('status', $status);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }
            $data = $query->latest()->get();
            $summary = [
                'total' => $data->count(),
                'aktif' => $data->where('status', 'aktif')->count(),
                'nonaktif' => $data->where('status', 'nonaktif')->count(),
            ];
        } 
        
        elseif ($type === 'pembayaran') {
            $query = Pendaftaran::with(['user', 'skema']);
            if ($status) {
                $query->where('status', $status);
            }
            if ($skemaId) {
                $query->where('skema_id', $skemaId);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }
            $data = $query->latest()->get();
            $summary = [
                'total' => $data->count(),
                'paid' => $data->where('status', 'paid')->count(),
                'pending' => $data->where('status', 'pending')->count(),
                'total_amount' => $data->where('status', 'paid')->sum('amount'),
            ];
        } 
        
        elseif ($type === 'hasil') {
            $query = Asesmen::with(['pendaftaran.user', 'pendaftaran.skema']);
            if ($status) {
                $query->where('status', $status);
            }
            if ($skemaId) {
                $query->whereHas('pendaftaran', function ($q) use ($skemaId) {
                    $q->where('skema_id', $skemaId);
                });
            }
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }
            $data = $query->latest()->get();
            $summary = [
                'total' => $data->count(),
                'lulus' => $data->where('status', 'lulus')->count(),
                'tidak_lulus' => $data->where('status', 'tidak_lulus')->count(),
                'berlangsung' => $data->where('status', 'berlangsung')->count(),
            ];
        } 
        
        elseif ($type === 'jadwal') {
            $query = Jadwal::with('skema');
            if ($skemaId) {
                $query->where('skema_id', $skemaId);
            }
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            }
            $data = $query->latest()->get();
            $summary = [
                'total' => $data->count(),
                'total_kuota' => $data->sum('kuota'),
            ];
        }

        return view('laporan.index', compact('skemas', 'type', 'data', 'summary'));
    }
}
