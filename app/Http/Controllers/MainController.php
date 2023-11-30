<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    /**
     * Show the main page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }
}
