<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssureTiers extends Model
{
    //
    protected $fillable = [
        'num_pol_tiers',
        'nom_tiers',
        'prenom_tiers',
        'num_tel_tiers',
        'contact_assurance_tiers',
        'num_matri_tiers',
        'nom_assurance_tiers',
        'active',
    ];

     public function sinistres()
    {
        return $this->belongsToMany(Sinistre::class, 'assure_tiers_sinistres', 'assure_tiers_id', 'sinistre_id');
    }
}
