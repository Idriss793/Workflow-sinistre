<?php

namespace App\Http\Controllers;

use App\Models\Statuts;
use App\Models\Sinistre;
use App\Models\Expertise;
use Illuminate\Http\Request;

class ExpertController extends Controller
{
    //
    public function index(Request $request){
        $query = Sinistre::with(['assurePrincipals','statut'])
        ->whereHas('statut',function($q){
            $q->where('ordre_statut','3');
        });
        $sinistres = $query->paginate(10)->appends($request->all());
        $title = "Expert";
        $url='indexExpert';
        return view('expert.indexExpert',compact('title','sinistres','url'));
    }

    public function show(string $id){
        $sinistres = Sinistre::with(['assureTiers','assurePrincipals','statut','documents'])->findorFail($id);
        //$experts = User::with('role')
            //->whereHas('role', function($q){
                //$q->where('lib_role','expert');
            //}) ->get();
    
        $title="Expert";
        $url='indexExpert';

        return view('expert.show',compact('sinistres','title','url'));
    }

    public function storeExpertise(Request $request){
        $request->validate([
            'estimation_degats' => 'nullable|numeric|min:0',
            'expertise_path'  => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'sinistre_id' => 'required|string|exists:sinistres,id',
        ]);

        $path = null;
        if ($request->hasFile('expertise_path')) {
            $path = $request->file('expertise_path')->store('expertises', 'public');
        }
        $sinistre = Sinistre::findOrFail($request->sinistre_id);

        $statut= Statuts::find('6');
        Expertise::create([
            'estimation_degats' => $request->estimation_degats,
            'expertise_path' => $path,
            'sinistre_id' => $request->sinistre_id,
            'statut_id'=> $statut-> id,
        ]);
         // Mise à jour du statut du sinistre (id = 6)
        $sinistre->update(['statut_id' => 6]);

        return back()->with('status','Expertise envoyée avec succès');
    }

    //Listes des rapports expertises réalisées par l'expert connecté
    public function listeExpertises(Request $request){
        $query = Expertise::with(['sinistre','expert','statut']);
        // ->where('expert_id',auth()->user()->id);
        $expertises = $query->paginate(10)->appends($request->all());
        $title = "Mes expertises";
        $url='listeExpertises';
        return view('expert.listeExpertises',compact('title','expertises','url'));
    }

    //Affichage du profil de l'expert
    public function profile(){
        $title = "Mon profil";
        $url='profileExpert';
        return view('expert.profile',compact('title','url'));
    }
}
