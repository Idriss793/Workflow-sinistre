<?php

namespace App\Models;

use App\Models\Sinistre;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable = [
        'type_doc',
        'nom_fichier',
        'taille',
        'path',
        'sinistre_id',
        'user_id',
        'assure_id',
        'assure_id_tiers',
        'passage_id',
        'active',
    ];

    public function sinistre(){
        return $this->belongsTo(Sinistre::class,'sinistre_id');
    }
}
