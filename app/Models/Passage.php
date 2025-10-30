<?php

namespace App\Models;

use App\Models\Sinistre;
use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    //
    protected $fillable = [
        'nom_passager',
        'prenom_passager',
        'date_naissance_passager',
        'type_passager',
    ];

    public function sinistres()
    {
        return $this->belongsToMany(Sinistre::class, 'passager_sinistre', 'passage_id', 'sinistre_id')
            ->withTimestamps();
    }

    
}
