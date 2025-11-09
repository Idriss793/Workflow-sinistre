<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserNotification;

class SinistreController  extends Controller
{
   
    public function index(Request $request){
        $title = "Gestionnaire";
        $url='home';
        $user = Auth::user();
        return view('gestionnaires.formDeclarationSinistre',compact('title','url','user'));
    }
    public function declarerSinistre(Request $request){
       
        $title = "Gestionnaire";
        $url='home';
        $user = Auth::user();
        return view('gestionnaires.declarerSinistre',compact('title','url','user'));
    }


    //Fonction pour la page d'accueil du gestionnaire (dashboard)
    // avec la liste des sinistre a traite et les défférents filtre
    
    public function home(Request $request){
        
        $query = Sinistre::with(['assurePrincipals','statut','experts'])
            ->where('user_id',auth()->user()->id)
             ->orderBy('created_at', 'desc')
        ;
        
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
        ->whereHas('role', function ($query) {
            $query->where('lib_role', 'expert');
        })
        ->withCount([
            'sinistresExpert as sinistres_en_cours_de_traitement' => function ($q) {
                $q->whereHas('statut', function ($sub) {
                    $sub->where('ordre_statut', 3);
                });
            }
        ])
        ->get();
        // ======================
        //  Calcul période
        // ======================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Cas : mois spécifique
            $debut = Carbon::create($maintenant->year, $request->mois, 1);
            $fin = $debut->copy()->endOfMonth();
        } else {
            switch ($request->periode) {
                case '1_semaine':
                    $debut = $maintenant->copy()->subWeek();
                    break;
                case '3_mois':
                    $debut = $maintenant->copy()->subMonths(3);
                    break;
                case '1_an':
                    $debut = $maintenant->copy()->subYear();
                    break;
                case '1_mois':
                default:
                    $debut = $maintenant->copy()->subMonth();
                    break;
            }
            $fin = $maintenant;
        }

        // ======================
        //  Données Dashboard
        // ======================
        $sinistres_declares = Sinistre::where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        $sinistres_clotures = Sinistre::where('user_id', auth()->user()->id)
            ->whereBetween('updated_at', [$debut, $fin])
            ->whereHas('statut', function ($q) {
                $q->where('lib_statut', 'clôturé')
                ->orWhere('ordre_statut', '7');
            })
            ->count();

        $en_attente = Sinistre::where('user_id', auth()->user()->id)
            ->whereHas('statut', function ($q) {
                $q->where('lib_statut', 'en attente')
                ->orWhere('ordre_statut', '6');
            })
            ->count();

        $taux_cloture = $sinistres_declares > 0
            ? round(($sinistres_clotures / $sinistres_declares) * 100)
            : 0;

        //titre
        $title="Gestionnaire";
        $url='home';
        $user = Auth::user();
        return view('gestionnaires.listeSinistre',compact('sinistres',
        'title', 'experts', 'url', 'user','sinistres_declares',
        'sinistres_clotures', 'taux_cloture', 'en_attente'));
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
            'user_id' => Auth()->id(),
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
        ->whereHas('role', function ($query) {
            $query->where('lib_role', 'expert');
        })
        ->withCount([
            'sinistresExpert as sinistres_en_cours_de_traitement' => function ($q) {
                $q->whereHas('statut', function ($sub) {
                    $sub->whereIn('ordre_statut', ['3', '6']);
                });
            }
        ])
        ->get();
        
         // ======================
        //  Calcul période
        // ======================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Cas : mois spécifique
            $debut = Carbon::create($maintenant->year, $request->mois, 1);
            $fin = $debut->copy()->endOfMonth();
        } else {
            switch ($request->periode) {
                case '1_semaine':
                    $debut = $maintenant->copy()->subWeek();
                    break;
                case '3_mois':
                    $debut = $maintenant->copy()->subMonths(3);
                    break;
                case '1_an':
                    $debut = $maintenant->copy()->subYear();
                    break;
                case '1_mois':
                default:
                    $debut = $maintenant->copy()->subMonth();
                    break;
            }
            $fin = $maintenant;
        }

            // ======================
            //  Données Dashboard
            // ======================
            $sinistres_declares = Sinistre::where('user_id', auth()->user()->id)
                ->whereBetween('created_at', [$debut, $fin])
                ->count();

            $sinistres_clotures = Sinistre::where('user_id', auth()->user()->id)
                ->whereBetween('updated_at', [$debut, $fin])
                ->whereHas('statut', function ($q) {
                    $q->where('lib_statut', 'clôturé')
                    ->orWhere('ordre_statut', '7');
                })
                ->count();

            $en_attente = Sinistre::where('user_id', auth()->user()->id)
                ->whereHas('statut', function ($q) {
                    $q->where('lib_statut', 'en attente')
                    ->orWhere('ordre_statut', '6');
                })
                ->count();

            $taux_cloture = $sinistres_declares > 0
                ? round(($sinistres_clotures / $sinistres_declares) * 100)
                : 0;


            
        $sinistres = Sinistre::with(['assurePrincipals','statut'])
          ->where('user_id',auth()->user()->id)
         ->orderBy('created_at', 'desc')
         ->paginate(10);
        $title = "Gestionnaire";
        $url='home';
        $user = Auth::user();
        return view('gestionnaires.listeSinistre',compact('sinistres','experts','title','url','user','sinistres_declares',
        'sinistres_clotures', 'taux_cloture', 'en_attente'))->with('status','Sinistre déclarer avec succès');
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
        $obligatoires = ['contrat', 'carte_grise', 'permis', 'constat'];

        // Pour afficher des noms lisibles par l'utilisateur
        $nomsDocuments = [
            'carte_grise' => 'Carte grise',
            'contrat'     => "Contrat de l'assuré",
            'permis'      => 'Permis de conduire',
            'constat'      => 'Constat amiable ou Constat de police',
        ];

        // Types de documents déjà fournis
        $fournis = $sinistres->documents
            ->pluck('type_doc')
            ->map(fn($type) => strtolower($type))
            ->unique();

        // Documents manquants
        $manquants = collect($obligatoires)->filter(fn($doc) => !$fournis->contains($doc));

        

        $title = "Gestionnaire";
        $url='home';
        $user = Auth::user();
         // Récupération des passagers associés à ce sinistre
            $passages = $sinistres->passagers()->paginate(10);

        $conducteurExiste = $sinistres->passagers()->where('type_passager', 'conducteur')->exists();

        return view('gestionnaires.index', compact('sinistres', 'manquants', 'passages','nomsDocuments', 'title','url', 'conducteurExiste', 'user'));
    }


    

   // Fonction pour attribuer un sinistre à un expert automobile
    public function attribuerExpert(string $id, Request $request)
    {
        $request->validate([
            'expert_id' => 'required|string',
        ]);

        $sinistre = Sinistre::with(['statut'])->findOrFail($id);

        // Vérifie le statut du sinistre avant attribution
        $ordre_status = $sinistre->statut->ordre_statut;

        if (in_array($ordre_status,[2,3,4,5,6,7,8])) {

            // Met à jour le statut du sinistre
            $nouveauStatut = Statuts::find(3); // Par exemple : "Expert assigné"
            $sinistre->statut_id = $nouveauStatut->id;
            $sinistre->save(); // On sauvegarde d'abord la mise à jour du statut

            // Attribue l'expert sans détacher les précédents
            $sinistre->experts()->syncWithoutDetaching([$request->expert_id]);
            $expert = User::find($request->expert_id);
            $expert->notify(new UserNotification('expert', [
                'num_sin' => $sinistre->numero_sinistre,
            ]));
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
        $user = Auth::user();
        return view('gestionnaires.profile',compact('title','url','user'));
    }

    public function updateProfile(Request $request){
        $user = Auth::user();

        // Validation des champs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6',
        ]);

        

        // Mise à jour des autres informations
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
        ]);

        // Si un nouveau mot de passe est saisi, on vérifie l'ancien
        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $user->password = Hash::make($validated['new_password']);
        }
        // Sauvegarde
        $user->save();

        // Retour avec message de succès
        return back()->with('success', 'Profil mis à jour avec succès.');
    }

}
