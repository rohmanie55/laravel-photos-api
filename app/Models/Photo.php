<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $casts   = ['tags'=>'array'];

    protected $appends = ['photo_url'];

    protected function getPhotoUrlAttribute()
    {
        return asset(Storage::url($this->path.'/'.$this->file_name));
    }

    public function likes(){
        return $this->hasMany(PhotoLike::class,'photo_id','id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
