<?php

namespace App\Http\Controllers;

use App\Models\Sinistre;
use Illuminate\Http\Request;

class ResponsableController extends Controller
{
    //
    public function index(Request $request){
        $query = Sinistre::with(['assurePrincipals','statut']);
        $title = "Responsable";
        $url='indexResponsable';
        //liste des sinistre attribué
        $sinistres = $query->paginate(10)->appends($request->all());
        return view('responsable.index',compact('sinistres','title','url'));
    }

    public function show(string $id){
        $sinistres = Sinistre::with(['assureTiers','assurePrincipals','statut','documents'])->findorFail($id);
       
    
        $title="Responsable";
        $url='indexResponsable';
        return view('responsable.show',compact('sinistres','title','url'));
    }

    public function showPersonnel(){
        $title = "Responsable";
        $url='indexResponsable';
        return view('responsable.personnel',compact('title','url'));
    }
}
