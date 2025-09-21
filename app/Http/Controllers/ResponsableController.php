<?php

namespace App\Http\Controllers;

use App\Models\Sinistre;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    //
    public function index(){
        $sinistres = Sinistre::with(['assurePrincipals','statut'])->get();
        $title = "Responsable";
        return view('responsable.index',compact('sinistres','title'));
    }
}
