<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpertController extends Controller
{
    //
    public function index(){
        $title = "Expert";
        return view('expert.indexExpert',compact('title'));
    }


}
