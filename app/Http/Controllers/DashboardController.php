<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin() 
    {
        return view('home');
    }
    public function super()
    {
        return view('super');
    }
}
