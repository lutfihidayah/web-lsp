<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class JadwalController extends Controller
{
    public function index()
    {
        return view('admin.jadwal');
    }
}