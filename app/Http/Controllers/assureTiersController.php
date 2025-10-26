<?php

namespace App\Http\Controllers;

use App\Models\AssureTiers;
use Illuminate\Http\Request;
use App\Models\AssureTiersSinistre;

class assureTiersController extends Controller
{
    //ajouter un assuré tiers
    public function storeAssureTiers(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nom_tiers' => 'required|string|max:255',
            'prenom_tiers' => 'required|string|max:255',
            'num_matri_tiers' => 'required|string|max:20',
            'num_pol_tiers' => 'required|string|max:20',
            'num_tel_tiers' => 'required|string|max:21',
            'nom_assurance_tiers' => 'required|string|max:255',
            'contact_assurance_tiers' => 'required|string|max:255',
        ]);

        // Enregistrement de l'assuré tiers
        $assureTiers = new AssureTiers();
        $assureTiers->nom_tiers = $request->nom_tiers;
        $assureTiers->prenom_tiers = $request->prenom_tiers;
        $assureTiers->num_matri_tiers = $request->num_matri_tiers;
        $assureTiers->num_pol_tiers = $request->num_pol_tiers;
        $assureTiers->num_tel_tiers = $request->num_tel_tiers;
        $assureTiers->nom_assurance_tiers = $request->nom_assurance_tiers;
        $assureTiers->contact_assurance_tiers = $request->contact_assurance_tiers;
        $assureTiers->save();

        AssureTiersSinistre::create([
            'assure_tiers_id' => $assureTiers -> id,
            'sinistre_id' => $request -> id,
        ]);
        return back()->with('status', 'Assuré tiers ajouté avec succès.');
    }

    // Pour modifier un assuré tiers
    public function updateAssureTiers(Request $request, $id)
    {
        $request->validate([
            'nom_tiers' => 'required|string|max:255',
            'prenom_tiers' => 'required|string|max:255',
            'num_matri_tiers' => 'required|string|max:20',
            'num_pol_tiers' => 'required|string|max:20',
            'num_tel_tiers' => 'required|string|max:21',
            'nom_assurance_tiers' => 'required|string|max:255',
            'contact_assurance_tiers' => 'required|string|max:255',
        ]);
        // Récupération de l’assuré tiers
        $assureTiers = AssureTiers::findOrFail($id);
        // Mise à jour
        $assureTiers->update([
            'nom_tiers' => $request->nom_tiers,
            'prenom_tiers' => $request->prenom_tiers,
            'num_matri_tiers' => $request->num_matri_tiers,
            'num_pol_tiers' => $request->num_pol_tiers,
            'num_tel_tiers' => $request->num_tel_tiers,
            'nom_assurance_tiers' => $request->nom_assurance_tiers,
            'contact_assurance_tiers' => $request->contact_assurance_tiers,
        ]);
        // Redirection avec message de succès
        return redirect()->back()->with('success', 'Assuré tiers mis à jour avec succès.');
    }
}
