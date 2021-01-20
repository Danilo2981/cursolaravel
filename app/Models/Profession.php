<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use SoftDeletes;
    
    use HasFactory;

    protected $fillable = ['title'];

    public function profiles()
    {
        return $this->hasMany(UserProfile::class);
    }

}
