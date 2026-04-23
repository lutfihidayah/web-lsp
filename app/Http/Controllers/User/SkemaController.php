<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Skema;

class SkemaController extends Controller
{
    public function index()
    {
        $skemas = Skema::where('status', 'Aktif')
                    ->withCount('peserta')
                    ->latest()
                    ->get();

        return view('user.skema', compact('skemas'));
    }

    public function show($id)
    {
        $skema = Skema::withCount('peserta')->findOrFail($id);
        return view('user.skema-detail', compact('skema'));
    }
}