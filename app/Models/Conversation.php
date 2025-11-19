<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['user_one_id', 'user_two_id', 'last_message_at'];
    
    protected $casts = [
        'last_message_at' => 'datetime',
    ];
    
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }
    
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }
    
    public function messages()
    {
        return $this->hasMany(DirectMessage::class);
    }
    
    public function latestMessage()
    {
        return $this->hasOne(DirectMessage::class)->latestOfMany();
    }
    
    public function getOtherUser($userId)
    {
        return $this->user_one_id == $userId ? $this->userTwo : $this->userOne;
    }
    
    public function unreadCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}
