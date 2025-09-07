<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sinistre extends Model
{
    //
    protected $fillable = [
        'date_sinistre',
        'lieu',
        'description',
        'type_sinistre',
        'image_id',
        'user_id',
        'statut_id',
        'active',
    ];
}
