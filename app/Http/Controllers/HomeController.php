<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        $labels = Labels::latest()->first();

        if (empty($labels)) {
            $labels = false;
        }

        return view('home', compact('labels'));
    }
}