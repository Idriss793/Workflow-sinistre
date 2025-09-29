<?php

namespace App\Models;

use App\Models\Sinistre;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    //
    protected $fillable = [
        'sinistre_id',
        'etat_general',
        'estimation_degats',
        'analyse_dommages',
        'recommandations',
        'reparable',
        'expertise_complementaire',
        'expertise_path',
        'expert_id',
    ];

    public function sinistre(){
        return $this->belongsTo(Sinistre::class);
    }
}
