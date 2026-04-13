<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skema;

class SkemaController extends Controller
{
    public function index()
    {
        $skemas = Skema::withCount('peserta')->latest()->get();
        return view('admin.skema', compact('skemas'));
    }
}