<?php

namespace App\Http\Controllers;

use App\Models\Labels;
use Illuminate\Http\Request;

class LabelController extends Controller {
    public function index() {
        $data = Labels::all();

        return view('labels', compact('data'));
    }
}