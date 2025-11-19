<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'message', 'image', 'is_read'];
    
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }
}
