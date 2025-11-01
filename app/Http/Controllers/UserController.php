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

    public function login(Request $request){
        // Validation des champs
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

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

                // Si la requête vient d'AJAX
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Votre compte est désactivé.'], 403);
                }

                return back()->withErrors(['identifier' => 'Votre compte est désactivé.'])->withInput();
            }

            // Régénère la session
            $request->session()->regenerate();

            // Récupère le rôle
            $role = strtolower($user->role->lib_role ?? '');

            // Détermine la redirection selon le rôle
            $routes = [
                'gestionnaire' => 'gestionnaire.home',
                'expert' => 'expert.index',
                'responsable' => 'responsable.index',
                'administrateur' => 'admin.formStatut',
            ];

            if (isset($routes[$role])) {
                $redirect = route($routes[$role]);

                // Si la requête vient d'AJAX
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'redirect' => $redirect
                    ]);
                }

                return redirect($redirect)->with('status', 'Connexion réussie !');
            }

            Auth::logout();

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Rôle non reconnu. Contactez un administrateur.'], 403);
            }

            return back()->withErrors(['identifier' => 'Rôle non reconnu. Contactez un administrateur.'])->withInput();
        }

        // Si l'authentification échoue
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Email ou mot de passe incorrect.'], 401);
        }

        return back()->withErrors(['identifier' => 'Email ou mot de passe incorrect.'])->withInput();
    }



}
