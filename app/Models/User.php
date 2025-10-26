<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Roles;
use App\Models\Sinistre;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'phone_number',
        'is_active',
        'email',
        'password',
        'role_id',
    ];

    public function role(){
        return $this->belongsTo(Roles::class,'role_id');
    }

    public function sinistres(){
        return $this->hasMany(Sinistre::class,'user_id');
    }

    //relation entre utilisateur expert et sinistre
    public function sinistresExpert(){
        return $this->belongsToMany(Sinistre::class, 'sinistre_user', 'sinistre_id', 'user_id')
        ->withTimestamps();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
