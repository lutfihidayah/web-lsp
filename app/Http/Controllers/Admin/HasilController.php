<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HasilController extends Controller
{
    public function index()
    {
        return view('admin.hasil');
    }
}