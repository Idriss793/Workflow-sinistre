<?php

namespace App\Http\Controllers;

use App\Models\Statuts;
use App\Models\Document;
use App\Models\Sinistre;
use App\Models\AssureTiers;
use Illuminate\Http\Request;
use App\Models\AssureSinistre;
use App\Models\AssurePrincipal;
use App\Models\AssureTiersSinistre;

class SinistreController  extends Controller
{
   
    public function index(Request $request){
        return view('gestionnaires.formDeclarationSinistre');
    }
    public function declarerSinistre(Request $request){
        return view('gestionnaires.declarerSinistre');
    }
    public function home(Request $request){
        $sinistres = Sinistre::with(['assurePrincipals','statut'])->get();
        return view('gestionnaires.listeSinistre',compact('sinistres'));
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

        $statut= Statuts::find('1');


        $Sinistre = Sinistre::create([
            'date_sinistre' => $request -> date_sinistre,
            'lieu' => $request -> lieu,
            'statut_id'=> $statut-> id,
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

        
        $sinistres = Sinistre::with(['assurePrincipals','statut'])->get();

        return view('gestionnaires.listeSinistre',compact('sinistres'))->with('status','Sinistre déclarer avec succès');
    }

    public function show(string $id){
        $sinistres = Sinistre::with(['assureTiers','assurePrincipals','statut','documents'])->findorFail($id);
        // Liste des types de documents obligatoires
        $obligatoires = ['contrat', 'carte_grise', 'permis'];
        //Pour afficher des noms de documents lisible par l'utilisateur
        $nomsDocuments = [
        'carte_grise' => 'Carte grise',
        'contrat' => "Contrat de l'assuré",
        'permis' => 'Permis de conduire',
        ];
        // Types de documents déjà fournis
        $fournis = $sinistres->documents->pluck('type_doc')->map(fn($type) => strtolower($type))->unique();
    
        // Documents manquants
        $manquants = collect($obligatoires)->filter(fn($doc) => !$fournis->contains($doc));


        //Mise à jours du status si tous les documents iobligatoire sont fournies
        if ($manquants->isEmpty()){
            $statut= Statuts::find('2');
            $sinistres->statut_id = $statut -> id;
            $sinistres->save();
        }else{
            $statut= Statuts::find('1');
            $sinistres->statut_id = $statut -> id;
            $sinistres->save();
        }

        return view('gestionnaires.index',compact('sinistres','manquants','nomsDocuments'));
    }
}
