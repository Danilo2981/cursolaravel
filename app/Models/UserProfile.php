<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
