<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeavesController extends Controller
{
    public function index()
    {
        return view('leaves');
    }
}
