<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the blank page template.
     */
    public function blank()
    {
        return view('layouts.blank-page');
    }
}
