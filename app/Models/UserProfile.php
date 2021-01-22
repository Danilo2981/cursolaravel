<?php

namespace App\Models;

use App\Models\Profession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use SoftDeletes;
    
    use HasFactory;

    //protected $fillable = [
    //    'bio',
    //    'twitter',
    //    'profession_id'
    // ];

    protected $guarded = [];

    // permite traer a una vista user valores de profession
    public function profession()
    {
        // Da un valor por defecto para poder llamar a los usuarios que no tienen profesion desde la vista users.index
        return $this->belongsTo(Profession::class)->withDefault([
            'title' => '(Sin profesion)'
        ]);
    }

}
