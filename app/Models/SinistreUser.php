<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinistreUser extends Model
{
    //
    protected $table =['sinistre_user'];

    protected $fillable = [
        'sinistre_id',
        'user_id',
    ];
    
}
