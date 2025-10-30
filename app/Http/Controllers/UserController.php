<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function showLoginForm(){
        return view('auth.login');
    }

    public function showRegisterForm(){
        $title = "Responsable";
        $url='indexResponsable';
        $user = Auth::user();
        return view('auth.register',compact('title','url','user'));
    }

    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Détermine si l'identifiant est un email ou un numéro de téléphone
        $field = filter_var($request->input('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        $credentials = [
            $field => $request->input('identifier'),
            'password' => $request->input('password'),
        ];

        // Tentative d'authentification
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Vérifie si le compte est actif
            if (isset($user->is_active) && !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'identifier' => 'Votre compte est désactivé.',
                ])->withInput();
            }

            // Régénère la session pour éviter les attaques de fixation
            $request->session()->regenerate();

            // 🔥 Détermination du rôle et redirection appropriée
            $role = strtolower($user->role->lib_role ?? '');

            switch ($role) {
                case 'gestionnaire':
                    return redirect()->route('gestionnaire.home')->with('status', 'Connexion réussie !');

                case 'expert':
                    return redirect()->route('expert.index')->with('status', 'Connexion réussie !');

                case 'responsable':
                    return redirect()->route('responsable.index')->with('status', 'Connexion réussie !');

                case 'administrateur':
                    return redirect()->route('admin.formStatut')->with('status', 'Connexion réussie !');

                default:
                    Auth::logout();
                    return back()->withErrors([
                        'identifier' => 'Rôle non reconnu. Contactez un administrateur.',
                    ])->withInput();
            }
        }

        // Si l'authentification échoue
        return back()->withErrors([
            'identifier' => 'Numéro de téléphone ou email incorrect.',
        ])->withInput();
    }


}
