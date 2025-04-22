<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index(){
        dd('index');
        return view('pos.index'); 
    }
}