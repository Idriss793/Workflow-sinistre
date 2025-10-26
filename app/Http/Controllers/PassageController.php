<?php

namespace App\Http\Controllers;

use App\Models\Passage;
use App\Models\Document;
use App\Models\Sinistre;
use Illuminate\Http\Request;

class PassageController extends Controller
{
    //formulaire de passage
    // public function formPassage(Request $request){
    //     $title = "Passage";
    //     $url='indexPassage';
    //     return view('passages.formPassage',compact('title','url'));
    // }


    //fonction pour enregistrer un passage
    public function storePassage(Request $request){
        $request->validate([
            'nom_passager' => 'required|string|max:255',
            'prenom_passager' => 'required|string|max:255',
            'date_naissance_passager' => 'required|date',
            'type_passager' => 'required|string|max:255',
            'sinistre_id' => 'required|exists:sinistres,id',
        ]);

        $sinistre = Sinistre::findOrFail($request->sinistre_id);
         // Vérifier s'il existe déjà un conducteur pour ce sinistre
        $conducteurExiste = $sinistre->passagers()->where('type_passager', 'conducteur')->exists();
        if ($conducteurExiste && $request->type_passager === 'conducteur') {
            return back()->with('status', 'Un conducteur est déjà enregistré pour ce sinistre.');
        }
        // Enregistrement du passage
        $passage = new Passage();
        $passage->nom_passager = $request->nom_passager;
        $passage->prenom_passager = $request->prenom_passager;
        $passage->date_naissance_passager = $request->date_naissance_passager;
        $passage->type_passager = $request->type_passager;
        $passage->save();

        // Liaison du passager au sinistre dans la table pivot
        $sinistre = Sinistre::findOrFail($request->sinistre_id);
        $sinistre->passagers()->attach($passage->id);
        return back()->with('status','Passager ajouté avec succès');
    }

    //liste des passages
    public function listePassage(Request $request){
        $query = Passage::query();
        $passages = $query->paginate(10)->appends($request->all());
        $title = "Gestionnaire";
        $url='home';
        return view('gestionnaires.partials.passages',compact('title','passages','url'));
    }

    //evoyer un document lié à un passage
    public function joindreDocument(Request $request){
        $request->validate([
            'type_doc' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'sinistre_id' => 'required|integer',
            'passage_id' => 'required|integer',
        ]);

        $fichier = $request->file('document');
        $nomFichier = time().'_'.$fichier->getClientOriginalName();
        $path = $fichier->storeAs('documents', $nomFichier, 'public');
        $tailleFichierLisible = $this->formatTaille($fichier->getSize());

        $document = new Document();
        $document->type_doc = $request->type_doc;
        $document->nom_fichier = $nomFichier;
        $document->path = $path;
        $document->taille = $tailleFichierLisible;
        $document->sinistre_id = $request->sinistre_id;
        $document->passage_id = $request->passage_id;
        // $document->user_id = Auth::id();
        $document->active = 1;
        $document->save();

        return back()->with('status', 'Document joint avec succès !');
    }

    //Fonction pour convertir en unité lisible selon la taille du fichier
    private function formatTaille($taille, $decimales = 2) {
        $unites = ['octets', 'Ko', 'Mo', 'Go', 'To'];
        for ($i = 0; $taille > 1024 && $i < count($unites) - 1; $i++) {
            $taille /= 1024;
        }
        return round($taille, $decimales) . ' ' . $unites[$i];
    }

    //fonction pour modifier un passage
    public function update(Request $request, $id){
        $request->validate([
            'nom_passager' => 'required|string|max:255',
            'prenom_passager' => 'required|string|max:255',
            'date_naissance_passager' => 'required|date',
            'type_passager' => 'required|string|max:255',
        ]);

        $passage = Passage::findOrFail($id);
        $passage->nom_passager = $request->nom_passager;
        $passage->prenom_passager = $request->prenom_passager;
        $passage->date_naissance_passager = $request->date_naissance_passager;
        $passage->type_passager = $request->type_passager;
        $passage->save();

        return back()->with('status','Passager modifié avec succès');
    }

    //fonction pour consulter un passage
    public function show($id)
    {
        $passage = Passage::findOrFail($id);

        // Récupération des documents liés
        $documents = Document::where('passage_id', $id)->get();

       return response()->json([
            'passage' => $passage,
            'documents' => $documents
        ]);
    }

}
