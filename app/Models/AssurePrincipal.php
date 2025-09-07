<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssurePrincipal extends Model
{
    //
    protected $fillable = [
        'nom',
        'prenom',
        'num_tel',
        'num_pol',
        'num_matri',
        'active',
    ];
}
