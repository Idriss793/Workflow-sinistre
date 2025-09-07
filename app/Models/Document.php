<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
    protected $fillable = [
        'type_doc',
        'taille',
        'id_sinistre',
        'id_user',
        'id_assure',
        'id_assure_tiers',
        'active',
    ];
}
