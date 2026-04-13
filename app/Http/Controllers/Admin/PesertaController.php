<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PesertaController extends Controller
{
    public function index()
    {
        return view('admin.peserta');
    }
}