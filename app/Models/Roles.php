<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    protected $fillable = [
        'lib_role',
        'description_role',
        'active',
    ];

    public function user(){
        return $this->hasMany(User::class,'role_id');
    }
}
