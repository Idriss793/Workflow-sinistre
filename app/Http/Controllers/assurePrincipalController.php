<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssurePrincipal;

class assurePrincipalController extends Controller
{
    // Pour modifier un assuré principal
    public function updateAssurePrincipal(Request $request, $id)
    {
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'num_tel' => 'required|string|max:21',
            'num_pol' => 'required|string|max:20',
            'num_matri' => 'required|string|max:20',
          
        ]);

        // Récupération de l’assuré
        $assure = AssurePrincipal::findOrFail($id);

        // Mise à jour
        $assure->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'num_tel' => $request->num_tel,
            'num_pol' => $request->num_pol,
            'num_matri' => $request->num_matri,
        ]);

        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Assuré principal mis à jour avec succès.');
    }

}
