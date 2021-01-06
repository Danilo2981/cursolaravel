<?php

namespace App\Models;

use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = ['is_admin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** Metodo estatico */
    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill');    
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    

}
