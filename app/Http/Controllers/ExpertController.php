<?php

namespace App\Http\Controllers;

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
            'etat_general' => 'nullable|string|max:5000',
            'estimation_degats' => 'nullable|numeric|min:0',
            'analyse_dommages'  => 'nullable|string',
            'recommandations'  => 'nullable|string',
            'reparable'  => 'nullable|boolean',
            'expertise_complementaire' => 'nullable|boolean',
            'expertise_path'  => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'sinistre_id' => 'required|string|exists:sinistres,id',
        ]);

        $path = null;
        if ($request->hasFile('expertise_path')) {
            $path = $request->file('expertise_path')->store('expertises', 'public');
        }

        Expertise::create([
            'etat_general' => $request->etat_general,
            'estimation_degats' => $request->estimation_degats,
            'analyse_dommages' => $request->analyse_dommages,
            'recommandations' => $request->recommandations,
            'reparable' => $request->reparable,
            'expertise_complementaire' => $request->expertise_complementaire,
            'expertise_path' => $path,
            'sinistre_id' => $request->sinistre_id,
        ]);

        return back()->with('status','Expertise envoyée avec succès');
    }


}
