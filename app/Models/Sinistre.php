<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class Sinistre extends Model
{
    //
    protected $fillable = [
        'numero_sinistre',
        'date_sinistre',
        'lieu',
        'description',
        'type_sinistre',
        'image_id',
        'user_id',
        'statut_id',
        'active',
    ];

    // Fonction pour la création automatique des numéros de sinistre
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sinistre) {
            // Récupère le dernier numéro
            $lastSinistre = Sinistre::latest('id')->first();
            $nextNumber = $lastSinistre ? ((int) substr($lastSinistre->numero_sinistre, 4)) + 1 : 1;

            // Format : SIN-001, SIN-002, ...
            $sinistre->numero_sinistre = 'SIN-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });
        
    }
     public function assurePrincipals()
    {
        return $this->belongsToMany(AssurePrincipal::class, 'assure_sinistres', 'sinistre_id', 'assure_id');
    }

    public function assureTiers()
    {
        return $this->belongsToMany(AssureTiers::class, 'assure_tiers_sinistres', 'sinistre_id', 'assure_tiers_id');
    }
    public function statut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }

    public function documents(){
        return $this->hasMany(Document::class, 'sinistre_id');
    }

}

