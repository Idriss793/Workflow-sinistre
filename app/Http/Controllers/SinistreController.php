<?php

namespace App\Http\Controllers;

use App\Models\Sinistre;
use App\Models\AssureTiers;
use Illuminate\Http\Request;
use App\Models\AssureSinistre;
use App\Models\AssurePrincipal;
use App\Models\AssureTiersSinistre;

class SinistreController  extends Controller
{
    public function home(Request $request){
        return view('gestionnaires.index');
    }
    public function listeSinistre(Request $request){
        return view('gestionnaires.liste_sinistre');
    }
    public function declarerSinistre(Request $request){
        return view('gestionnaires.declarerSinistre');
    }
  

    public function store(Request $request){
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'num_tel' => 'required|string',
            'num_pol'=> 'required|string',
            'num_matri'=> 'required|string',
            'date_sinistre' => 'required|date',
            'lieu'=> 'required|string',
            'type_sinistre'=> 'required|string',
            'description'=> 'required|string',
            'nom_tiers'=> 'nullable|string',
            'prenom_tiers'=> 'nullable|string',
            'num_tel_tiers'=> 'nullable|string',
            'num_pol_tiers'=> 'nullable|string',
            'num_matri_tiers'=> 'nullable|string',
            'nom_assurance_tiers'=> 'nullable|string',
            'contact_assurance_tiers'=> 'nullable|string',
        ]);

        $Sinistre = Sinistre::create([
            'date_sinistre' => $request -> date_sinistre,
            'lieu' => $request -> lieu,
            'type_sinistre' => $request -> type_sinistre,
            'description' => $request -> description,
        ]);

        $Assure_principal = AssurePrincipal::create([
            'nom' => $request -> nom,
            'prenom' => $request -> prenom,
            'num_tel' => $request -> num_tel,
            'num_pol' => $request -> num_pol,
            'num_matri' => $request -> num_matri,
        ]);

        $Assure_tiers = AssureTiers::create([
            'nom_tiers' => $request -> nom_tiers,
            'prenom_tiers' => $request -> prenom_tiers,
            'num_tel_tiers' => $request -> num_tel_tiers,
            'num_pol_tiers' => $request -> num_pol_tiers,
            'nom_assurance_tiers' => $request -> nom_assurance_tiers,
            'contact_assurance_tiers' => $request -> contact_assurance_tiers,
        ]);

        AssureSinistre::create([
            'assure_id' => $Assure_principal -> id,
            'sinistre_id' => $Sinistre -> id,
        ]);

        AssureTiersSinistre::create([
            'assure_tiers_id' => $Assure_tiers -> id,
            'sinistre_id' => $Sinistre -> id,
        ]);
        

        return back()->with('status','Sinistre déclarer avec succès');
    }
}
