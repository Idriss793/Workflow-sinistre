<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Passage;
use App\Models\Statuts;
use App\Models\Sinistre;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExpertController extends Controller
{
    //
    public function index(Request $request){
        $expert_id = Auth::id();
        $query = Sinistre::with(['assurePrincipals','statut','experts'])
        ->whereHas('experts', function ($q) {
            $q->where('user_id', Auth::id());
        })
        ->whereHas('statut',function($q){
            $q->where('ordre_statut','3');
        });
        $sinistres = $query->paginate(10)->appends($request->all());

        
        // ========================
        // Calcul période Dashboard
        // ========================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Si l'utilisateur choisit un mois précis
            $annee = $maintenant->year;
            $mois = $request->mois;
            $debut = Carbon::create($annee, $mois, 1)->startOfMonth();
            $fin = Carbon::create($annee, $mois, 1)->endOfMonth();
        } else {
            // Sinon on applique la période générale
            switch ($request->periode) {
                case 'semaine':
                    $debut = $maintenant->copy()->startOfWeek();
                    break;
                case '3mois':
                    $debut = $maintenant->copy()->subMonths(3);
                    break;
                case 'an':
                    $debut = $maintenant->copy()->startOfYear();
                    break;
                default: // 'mois' ou non défini
                    $debut = $maintenant->copy()->startOfMonth();
                    break;
            }

            $fin = $maintenant;
        }
        // ========================
        // Statistiques
        // ========================
        $a_traiter = Sinistre::whereHas('experts', fn($q) => $q->where('user_id',  $expert_id))
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 3))
            
            ->count();

        
        // Sinistres traités = expertise rédigée + statut "en attente de validation"
        $traites = Expertise::where('expert_id', Auth::id())
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 6))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        // Sinistres validés = expertise validée (statut 5)
        $valide = Expertise::where('expert_id', $expert_id)
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 5))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        // Sinistres rejetés = expertise rejetée (statut 4)
        $rejete = Expertise::where('expert_id', $expert_id)
            ->whereHas('sinistre.statut', fn($q) => $q->where('ordre_statut', 4))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        $title = "Expert";
        $url='indexExpert';
        $user = Auth::user();
        return view('expert.indexExpert',compact('title','sinistres','url','user',
        'a_traiter', 'traites', 'valide', 'rejete'));
    }

    public function show(string $id){
       $sinistres = Sinistre::with([
            'assureTiers',
            'assurePrincipals',
            'statut',
            'documents'
        ])->findOrFail($id);

        // Pagination sur la relation many-to-many
        $passages = $sinistres->passagers()->paginate(10);
        $title="Expert";
        $url='indexExpert';
        $user = Auth::user();
        return view('expert.show',compact('sinistres','title','passages','url','user'));
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
        $query = Expertise::with(['sinistre','expert','statut'])
        ->where('expert_id',auth()->user()->id);
        
            
        // Recherche globale : nom assuré OU numéro sinistre
            $query->when($request->search, function($q) use ($request){
                $q->where('numero_sinistre', 'like', '%' .$request->search. '%')
                ->orWhereHas('assurePrincipals', function($sub) use ($request){
                    $sub->where('nom', 'like', '%'.$request->search. '%');
                });
            });

            //filtre par status
            $query->when($request->statut, function($q) use ($request){
                $q->whereHas('statut',function($sub) use ($request){
                    $sub->where('ordre_statut',$request->statut);
                });
            });

            // Filtre par période
            $query->when($request->date_declaration , function($q) use ($request) {
                $q->whereDate('created_at', $request->date_declaration);
            });

        $expertises = $query->paginate(10)->appends($request->all());
        $title = "Mes expertises";
        $url='listeExpertises';
        $user = Auth::user();

        return view('expert.listeExpertises',compact('title','expertises','url','user'));
    }

    //Affichage du profil de l'expert
    public function profile(){
        $title = "Mon profil";
        $url='profileExpert';
        $user = Auth::user();
        return view('expert.profile',compact('title','url','user'));
    }

    public function search(Request $request){
        $expert_id = Auth::id();

        // ========================
        // Base de la requête
        // ========================
        $query = Sinistre::with(['assurePrincipals', 'statut', 'experts'])
            ->whereHas('experts', function ($q) use ($expert_id) {
                $q->where('user_id', $expert_id);
            });

        // Recherche globale
        $query->when($request->search, function ($q) use ($request) {
            $q->where('numero_sinistre', 'like', '%' . $request->search . '%')
                ->orWhereHas('assurePrincipals', function ($sub) use ($request) {
                    $sub->where('nom', 'like', '%' . $request->search . '%');
                });
        });

        // Filtre par statut
        $query->when($request->statut, function ($q) use ($request) {
            $q->whereHas('statut', function ($sub) use ($request) {
                $sub->where('ordre_statut', $request->statut);
            });
        });

        // Filtre par date précise
        $query->when($request->date_declaration, function ($q) use ($request) {
            $q->whereDate('created_at', $request->date_declaration);
        });

        $sinistres = $query->paginate(10)->appends($request->all());

        // ========================
        // Calcul période Dashboard
        // ========================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Si l'utilisateur choisit un mois précis
            $annee = $maintenant->year;
            $mois = $request->mois;
            $debut = Carbon::create($annee, $mois, 1)->startOfMonth();
            $fin = Carbon::create($annee, $mois, 1)->endOfMonth();
        } else {
            // Sinon on applique la période générale
            switch ($request->periode) {
                case 'semaine':
                    $debut = $maintenant->copy()->startOfWeek();
                    break;
                case '3mois':
                    $debut = $maintenant->copy()->subMonths(3);
                    break;
                case 'an':
                    $debut = $maintenant->copy()->startOfYear();
                    break;
                default: // 'mois' ou non défini
                    $debut = $maintenant->copy()->startOfMonth();
                    break;
            }

            $fin = $maintenant;
        }

        // ========================
        // Statistiques
        // ========================
        $a_traiter = Sinistre::whereHas('experts', fn($q) => $q->where('user_id',  $expert_id))
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 3))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        
        // Sinistres traités = expertise rédigée + statut "en attente de validation"
        $traites = Expertise::where('expert_id', Auth::id())
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 6))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        // Sinistres validés = expertise validée (statut 5)
        $valide = Expertise::where('expert_id', $expert_id)
            ->whereHas('statut', fn($q) => $q->where('ordre_statut', 5))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        // Sinistres rejetés = expertise rejetée (statut 4)
        $rejete = Expertise::where('expert_id', $expert_id)
            ->whereHas('sinistre.statut', fn($q) => $q->where('ordre_statut', 4))
            ->whereBetween('created_at', [$debut, $fin])
            ->count();

        // ========================
        // Variables d'affichage
        // ========================
        $title = "Expert";
        $url = 'listeExpertises';
        $user = Auth::user();

        return view('expert.indexExpert', compact(
            'sinistres', 'title', 'url', 'user',
            'a_traiter', 'traites', 'valide', 'rejete'
        ));
    }




    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation des champs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6',
        ]);

        // Si un nouveau mot de passe est saisi, on vérifie l'ancien
        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $user->password = Hash::make($validated['new_password']);
        }

        // Mise à jour des autres informations
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
        ]);

        // Sauvegarde
        $user->save();

        // Retour avec message de succès
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
