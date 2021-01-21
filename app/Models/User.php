<?php

namespace App\Models;

use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = [
    //    'name',
    //    'email',
    //    'password',
    // ];

    protected $guarded = [];

    // define la cantidad de lineas a ver en la vista
    protected $perPage = 15;

    // multiplica la cantidad de lineas de perPage
    public function getPerPage()
    {
        return parent::getPerPage() * 1;
    }
    
    

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

    // withDefault establece un perfil por defecto
    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }


    public function delete()
    {
        DB::transaction(function(){
            if (parent::delete()) {
                $this->profile()->delete();
        
                DB::table('user_skill')
                    ->where('user_id', $this->id)
                    ->update(['deleted_at' => now()]);
            }
        });
        
    }

    public function restore()
    {
        DB::transaction(function(){
            if (parent::restore()){
                $this->profile()->restore();

            DB::table('user_skill')
                ->where('user_id', $this->id)
                ->update(array('deleted_at' => null));

                }
        });
    }

    

}
