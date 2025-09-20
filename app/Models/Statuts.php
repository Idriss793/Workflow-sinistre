<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statuts extends Model
{
    //
    protected $table = 'statuts';
    protected $fillable = [
        'lib_statut',
        'description_statut',
        'ordre_statut',
        'active'
    ];
    public function sinistres()
    {
        return $this->hasMany(Sinistre::class, 'statut_id');
    }
}
