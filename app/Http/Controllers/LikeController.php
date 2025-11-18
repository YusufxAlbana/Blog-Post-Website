<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // This controller is ONLY for MESSAGE likes
    // Post likes are handled by PostLikeController
    
    public function toggleMessageLike(Message $message)
    {
        $user = auth()->user();
        
        // Check if already liked
        $existingLike = \App\Models\Like::where('user_id', $user->id)
            ->where('likeable_id', $message->id)
            ->where('likeable_type', Message::class)
            ->first();
        
        if ($existingLike) {
            // Unlike - delete existing like
            $existingLike->delete();
            $liked = false;
        } else {
            // Like - create new like record
            \App\Models\Like::create([
                'user_id' => $user->id,
                'likeable_id' => $message->id,
                'likeable_type' => Message::class
            ]);
            $liked = true;
        }
        
        // Get fresh count from database
        $likesCount = \App\Models\Like::where('likeable_id', $message->id)
            ->where('likeable_type', Message::class)
            ->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}
