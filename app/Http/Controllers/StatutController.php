<?php

namespace App\Http\Controllers;

use App\Models\Statuts;
use Illuminate\Http\Request;

class StatutController extends Controller
{
    //
    public function index(){
        $title = "Administrateur";
        return view('admin.createStatut',compact('title'));
    }
    public function store(Request $request){
        $request->validate([
            'lib_statut' => 'required|string',
            'description_statut' => 'nullable|string',
            'ordre_statut' => 'required|string',
        ]);

        Statuts::create([
            'lib_statut' =>  $request-> lib_statut,
            'description_statut' =>  $request-> description_statut,
            'ordre_statut' =>  $request-> ordre_statut,
        ]);

        return back()->with('status','Statut créer avec succès');
    }
}
