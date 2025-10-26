<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Statuts;
use App\Models\Document;
use App\Models\Sinistre;
use App\Models\AssureTiers;
use App\Models\SinistreUser;
use Illuminate\Http\Request;
use App\Models\AssureSinistre;
use App\Models\AssurePrincipal;
use App\Models\AssureTiersSinistre;

class SinistreController  extends Controller
{
   
    public function index(Request $request){
        $title = "Gestionnaire";
        $url='home';
        return view('gestionnaires.formDeclarationSinistre',compact('title','url'));
    }
    public function declarerSinistre(Request $request){
       
        $title = "Gestionnaire";
        $url='home';

        return view('gestionnaires.declarerSinistre',compact('title','url'));
    }


    //Fonction pour la page d'accueil du gestionnaire (dashboard)
    // avec la liste des sinistre a traite et les défférents filtre
    
    public function home(Request $request){
        $query = Sinistre::with(['assurePrincipals','statut','experts']);
        
        // Recherche globale : nom assuré OU numéro sinistre
        $query->when($request->search, function($q) use ($request){
            $q->where('numero_sinistre', 'like', '%' .$request->search. '%')
            ->orWhereHas('assurePrincipals', function($sub) use ($request){
                $sub->where('nom', 'like', '%'.$request->search. '%');
            });
        });

        //filltre par status
        $query->when($request->statut, function($q) use ($request){
            $q->whereHas('statut',function($sub) use ($request){
                $sub->where('ordre_statut',$request->statut);
            });
        });

        //filttre par type de sinistre
        $query->when($request->type_sinistre, function($q) use ($request){
            $q->where('type_sinistre',$request->type_sinistre);
        });

         // Filtre par période
        $query->when($request->date_declaration , function($q) use ($request) {
            $q->whereDate('created_at', $request->date_declaration);
        });

        //liste des sinistre attribué
        $sinistres = $query->paginate(10)->appends($request->all());

        //Liste des experts
        $experts = User::with('role')
            ->whereHas('role',function ($query){
                $query->where('lib_role','expert');
            })
        ->get();
        //titre
        $title="Gestionnaire";
        $url='home';

        return view('gestionnaires.listeSinistre',compact('sinistres','title','experts','url'));
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
            'num_matri_tiers' => $request -> num_matri_tiers,
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

        //Liste des experts
        $experts = User::with('role')
            ->whereHas('role',function ($query){
                $query->where('lib_role','expert');
            }) ->get();
        $sinistres = Sinistre::with(['assurePrincipals','statut'])
         ->orderBy('created_at', 'desc')
         ->paginate(10);
        $title = "Gestionnaire";
        $url='home';
        return view('gestionnaires.listeSinistre',compact('sinistres','experts','title','url'))->with('status','Sinistre déclarer avec succès');
    }

    public function show(string $id)
    {
        $sinistres = Sinistre::with([
            'assureTiers',
            'assurePrincipals',
            'statut',
            'documents',
            'users',
            'expertise.expert',
            'expertise.statut',
             'passagers',
        ])->findOrFail($id);

        // Liste des types de documents obligatoires
        $obligatoires = ['contrat', 'carte_grise', 'permis'];

        // Pour afficher des noms lisibles par l'utilisateur
        $nomsDocuments = [
            'carte_grise' => 'Carte grise',
            'contrat'     => "Contrat de l'assuré",
            'permis'      => 'Permis de conduire',
        ];

        // Types de documents déjà fournis
        $fournis = $sinistres->documents
            ->pluck('type_doc')
            ->map(fn($type) => strtolower($type))
            ->unique();

        // Documents manquants
        $manquants = collect($obligatoires)->filter(fn($doc) => !$fournis->contains($doc));

       if (in_array(strtolower($sinistres->statut->lib_statut), ["en attente d'expert", "en attente d'expertise"])) {
            $sinistres->statut_id = $manquants->isEmpty() ? 2 : 1;
            $sinistres->save();
        }
        $title = "Gestionnaire";
        $url='home';
         // Récupération des passagers associés à ce sinistre
            $passages = $sinistres->passagers()->paginate(10);

        $conducteurExiste = $sinistres->passagers()->where('type_passager', 'conducteur')->exists();

        return view('gestionnaires.index', compact('sinistres', 'manquants', 'passages','nomsDocuments', 'title','url', 'conducteurExiste'));
    }


    

   // Fonction pour attribuer un sinistre à un expert automobile
    public function attribuerExpert(string $id, Request $request)
    {
        $request->validate([
            'expert_id' => 'required|string',
        ]);

        $sinistre = Sinistre::with(['statut'])->findOrFail($id);

        // Vérifie le statut du sinistre avant attribution
        $libelle = strtolower($sinistre->statut->lib_statut);

        if ($libelle === "en attente d'expert" || $libelle === "en attente d'expertise") {

            // Met à jour le statut du sinistre
            $nouveauStatut = Statuts::find(3); // Par exemple : "Expert assigné"
            $sinistre->statut_id = $nouveauStatut->id;
            $sinistre->save(); // On sauvegarde d'abord la mise à jour du statut

            // Attribue l'expert sans détacher les précédents
            $sinistre->experts()->syncWithoutDetaching([$request->expert_id]);

            return redirect()->back()->with('status', 'Sinistre attribué avec succès');
        }

        return redirect()->back()->with('error', "Impossible d'attribuer un expert à ce sinistre car il y a des documents manquants");
    }


    //Fonction pour annuler l'attribution d'un expert$
    public function annulerExpert($sinistre_id, $expert_id){
        $sinistre = Sinistre::with(['experts'])->findOrFail($sinistre_id);
        $sinistre->experts()->detach($expert_id);
        $sinistre->save();
        return redirect()->back()->with('status','Expert retiré avec succès');

    }

    //Affichage du profil du gestionnaire
    public function profileGestionnaire(Request $request){
        $title = "Gestionnaire";
        $url='home';
        return view('gestionnaires.profile',compact('title','url'));
    }
}
