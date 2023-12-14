<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(){
        return view('index');
    }

    public function success(){
        return view('success');
    }

    public function error(){
        return view('error');
    }
}
