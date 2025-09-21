<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //

    public function store(Request $request){
        $request->validate([
            'type_doc'=> 'required|string',
            'path'=> 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'nom_fichier'=> 'nullable|string',
            'sinistre_id'=> 'required|exists:sinistres,id',
        ]);

        $fichier = $request->file('path');
        //récupération du chemin du fichier dans le storage
        $chemin = $fichier->store('documents', 'public');
        
        //récupération de la taille du fichier et conversion en format lisible
        $tailleFichierLisible = $this->formatTaille($fichier->getSize());

        Document::create([
            'type_doc' => $request-> type_doc,
            'path' =>$chemin,
            'nom_fichier' => $request -> nom_fichier ?? basename($chemin),
            'sinistre_id' => $request -> sinistre_id,
            'taille' =>$tailleFichierLisible,
        ]);
        $nomFichier = $request->nom_fichier ?? basename($chemin);
        return back()->with('status', "$nomFichier ajouté avec succès");
    }


    //Fonction pour convertir en unité lisible selon la taille du fichier
    private function formatTaille($taille, $decimales = 2) {
        $unites = ['octets', 'Ko', 'Mo', 'Go', 'To'];
        for ($i = 0; $taille > 1024 && $i < count($unites) - 1; $i++) {
            $taille /= 1024;
        }
        return round($taille, $decimales) . ' ' . $unites[$i];
    }

    public function verifyDocument(String $id){
        $sinistres = Sinistre::with(['documents'])->findorFail($id);
        //$sinistres->documents->whereIn('type_doc', ['photos',]) as $document
    }
}
