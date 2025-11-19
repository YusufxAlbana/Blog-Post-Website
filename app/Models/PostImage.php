<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'image_path', 'order'];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
