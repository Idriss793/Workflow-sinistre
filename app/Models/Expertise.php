<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
     //
    protected $fillable = [
        'sinistre_id',
        'estimation_degats',
        'expertise_path',
        'statut_id',
        'expert_id',
    ];

    public function sinistre(){
        return $this->belongsTo(Sinistre::class);
    }
    public function expert()
    {
        return $this->belongsTo(User::class, 'expert_id');
    }
      public function statut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }
}
