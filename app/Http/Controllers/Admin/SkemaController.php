<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SkemaController extends Controller
{
    public function index()
    {
        return view('admin.skema');
    }
}