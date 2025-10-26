<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
         // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('Veuillez vous connecter.');
        }

        // Vérifie si le rôle correspond
        $user = Auth::user();
        if ($user->role && strtolower($user->role->lib_role) === strtolower($role)) {
            return $next($request);
        }

        // Sinon, accès refusé
        abort(403, "Accès interdit — Vous n'avez pas la permission d'accéder à cette page.");
    }
    
}
