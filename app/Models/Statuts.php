<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statuts extends Model
{
    //
    protected $fillable = [
        'lib_statut',
        'description_statut',
        'ordre_statut',
        'active'
    ];
}
