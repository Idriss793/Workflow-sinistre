<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Passage;
use App\Models\Statuts;
use App\Models\Sinistre;
use App\Models\Expertise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResponsableController extends Controller
{
    //fonction pour afficher la liste des sinistres attribués à un responsable
    public function index(Request $request){
        $query = Sinistre::with(['assurePrincipals', 'statut', 'experts']);
        // =============================
        //  Calcul période personnalisée
        // =============================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Mois spécifique
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

        // =============================
        //  Données Dashboard globales
        // =============================

        // Tous les sinistres du système
        $sinistres_declares = Sinistre::whereBetween('created_at', [$debut, $fin])->count();

        // Sinistres clôturés
        $sinistres_clotures = Sinistre::whereBetween('updated_at', [$debut, $fin])
            ->whereHas('statut', function ($q) {
                $q->where('lib_statut', 'clôturé')
                ->orWhere('ordre_statut', '7');
            })
            ->count();

        // Sinistres en attente
        $en_attente = Sinistre::whereHas('statut', function ($q) {
            $q->where('lib_statut', 'en attente')
            ->orWhere('ordre_statut', '6');
        })->count();

        // Calcul du taux de clôture
        $taux_cloture = $sinistres_declares > 0
            ? round(($sinistres_clotures / $sinistres_declares) * 100)
            : 0;

        //Titre
        $title = "Responsable";
        $url='indexResponsable';
        $user = Auth::user();
        //liste des sinistre attribué
        $sinistres = $query->paginate(10)->appends($request->all());


        return view('responsable.index',compact('sinistres','title','url','user',
    'sinistres_declares',
    'sinistres_clotures',
    'taux_cloture',
    'en_attente'));
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
        ])->findOrFail($id);

        // Pagination sur la relation many-to-many
        $passages = $sinistres->passagers()->paginate(10);

        $expertises = $sinistres->expertise()->with(['expert', 'statut'])->paginate(5);


        $title = "Responsable";
        $url = 'indexResponsable';
        $user = Auth::user();

        return view('responsable.show', compact('sinistres', 'user','title', 'url', 'passages', 'expertises'));
    }



    public function showPersonnel(){
        // Récupération de tous les utilisateurs
        $utilisateurs = \App\Models\User::orderBy('name')->paginate(10);

        $title = "Responsable";
        $url='indexResponsable';
        $user = Auth::user();
        return view('responsable.personnel', compact('utilisateurs', 'title', 'url', 'user'));
    }
    

    //Affichage du profil du gestionnaire
    public function profile(){
        $title = "Mon profil";
        $url='profileResponsable';
        $user = Auth::user();
        return view('responsable.profile',compact('title','user','url'));
    }

    public function search(Request $request)
    {
        $query = Sinistre::with(['assurePrincipals', 'statut', 'experts']);

        // =============================
        //  Filtres de recherche
        // =============================
        $query->when($request->search, function($q) use ($request) {
            $q->where('numero_sinistre', 'like', '%' . $request->search . '%')
            ->orWhereHas('assurePrincipals', function($sub) use ($request) {
                $sub->where('nom', 'like', '%' . $request->search . '%');
            });
        });

        // Filtre par statut
        $query->when($request->statut, function($q) use ($request) {
            $q->whereHas('statut', function($sub) use ($request) {
                $sub->where('ordre_statut', $request->statut);
            });
        });

        // Filtre par type de sinistre
        $query->when($request->type_sinistre, function($q) use ($request) {
            $q->where('type_sinistre', $request->type_sinistre);
        });

        // Filtre par date de déclaration précise
        $query->when($request->date_declaration, function($q) use ($request) {
            $q->whereDate('created_at', $request->date_declaration);
        });

        // Récupération paginée des sinistres
        $sinistres = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());


        // =============================
        //  Calcul période personnalisée
        // =============================
        $maintenant = Carbon::now();

        if ($request->filled('mois')) {
            // Mois spécifique
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

        // =============================
        //  Données Dashboard globales
        // =============================

        // Tous les sinistres du système
        $sinistres_declares = Sinistre::whereBetween('created_at', [$debut, $fin])->count();

        // Sinistres clôturés
        $sinistres_clotures = Sinistre::whereBetween('updated_at', [$debut, $fin])
            ->whereHas('statut', function ($q) {
                $q->where('lib_statut', 'clôturé')
                ->orWhere('ordre_statut', '7');
            })
            ->count();

        // Sinistres en attente
        $en_attente = Sinistre::whereHas('statut', function ($q) {
            $q->where('lib_statut', 'en attente')
            ->orWhere('ordre_statut', '6');
        })->count();

        // Calcul du taux de clôture
        $taux_cloture = $sinistres_declares > 0
            ? round(($sinistres_clotures / $sinistres_declares) * 100)
            : 0;

        // =============================
        //  Vue
        // =============================
        $title = "Responsable";
        $url = 'indexResponsable';
        $user = Auth::user();

        return view('responsable.index', compact(
            'sinistres',
            'title',
            'url',
            'user',
            'sinistres_declares',
            'sinistres_clotures',
            'taux_cloture',
            'en_attente'
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


    // fonction pour valider un sinistre
    public function validerSinistre($id){
        $sinistre = Sinistre::findOrFail($id);
        $statutValide = Statuts::where('ordre_statut', 5)->first();
        $sinistre->statut_id = $statutValide->id;
        //$expertise = $sinistre->expertise()->where('statut_id', '!=', 7)->first();
        $sinistre->save();
        return redirect()->back()->with('status','Sinistre validé avec succès');
    }

    // fonction pour rejeter un sinistre
    public function rejeterSinistre($id){
        $sinistre = Sinistre::findOrFail($id);
        $statutRejete = Statuts::where('ordre_statut', 4)->first();
        $sinistre->statut_id = $statutRejete->id;
        $sinistre->save();
        return redirect()->back()->with('status','Sinistre rejeté avec succès');
    }

    public function validerExpertise($id)
    {
        $expertise = Expertise::with('sinistre')->findOrFail($id);
        $sinistre = $expertise->sinistre;

        DB::transaction(function () use ($expertise, $sinistre) {
            // Valider cette expertise
            $expertise->update([
                'statut_id' => Statuts::where('ordre_statut', 5)->first()->id
            ]);

            // Refuser toutes les autres expertises du même sinistre
            Expertise::where('sinistre_id', $sinistre->id)
                ->where('id', '!=', $expertise->id)
                ->update([
                    'statut_id' => Statuts::where('ordre_statut', 4)->first()->id
                ]);

            // Mettre à jour le statut du sinistre
            $sinistre->update([
                'statut_id' => Statuts::where('ordre_statut', 5)->first()->id
            ]);
        });

        return response()->json(['success' => true]);
    }

    public function refuserExpertise(Request $request, $id)
    {
        $expertise = Expertise::findOrFail($id);
        $expertise->update([
            'statut_id' => 4, // exemple : 4 = Refusé
            'motif_refus' => $request->motif
        ]);
        return response()->json(['success' => true]);
    }


}
