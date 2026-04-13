<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest()->get();
        return view('admin.informasi', compact('informasi'));
    }
}