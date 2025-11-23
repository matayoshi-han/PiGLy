<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //indexビューを表示する
    public function index()
    {
        return view('index');
    }
}
