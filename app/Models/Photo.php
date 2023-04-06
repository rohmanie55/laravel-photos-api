<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $casts = ['tags'=>'array'];

    public function likes(){
        return $this->hasMany(PhotoLike::class,'photo_id','id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
