<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    public function store(Request $request)
    {
        //Validation des données
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'first_name'   => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|email|max:255|unique:users,email',
            'role'         => 'required|string',
            'password'     => 'required|string|min:6',
        ]);


        // Création de l’utilisateur
        $user = User::create([
            'name'         => $validated['name'],
            'first_name'   => $validated['first_name'],
            'phone_number' => $validated['phone_number'],
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'role_id'      => $this->getRoleId($validated['role']),
            'is_active'    => 1, // par défaut actif
        ]);

        // Message de succès
        return redirect()->back()->with('success', 'Utilisateur ajouté avec succès !');
    }

    /**
     * Retourne l'ID du rôle selon son nom.
     * Tu peux adapter cette fonction selon ta table `roles`.
     */
    private function getRoleId($roleName)
    {
        return Roles::where('lib_role', strtolower($roleName))->value('id');
    }

    

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = 0;
        $user->save();

        return redirect()->back()->with('status', 'Utilisateur bloqué avec succès.');
    }

    public function unblock($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = 1;
        $user->save();

        return redirect()->back()->with('status', 'Utilisateur débloqué avec succès.');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'first_name'  => 'required|string|max:255',
            'phone_number'=> 'required|string|max:20',
            'email'       => 'required|email|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->back()->with('status', 'Utilisateur modifié avec succès !');
    }


    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'status' => 'success',
            'active' => $user->is_active,
            'message' => $user->is_active ? 'Utilisateur activé' : 'Utilisateur désactivé'
        ]);
    }

}
