<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Message;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function togglePostLike(Post $post)
    {
        $user = auth()->user();
        
        // Check if already liked
        $like = $post->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            // Unlike
            $like->delete();
            $liked = false;
        } else {
            // Like - create new like record
            $post->likes()->create([
                'user_id' => $user->id,
                'likeable_id' => $post->id,
                'likeable_type' => Post::class
            ]);
            $liked = true;
        }
        
        // Get fresh count from database
        $likesCount = $post->likes()->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }

    public function toggleMessageLike(Message $message)
    {
        $user = auth()->user();
        
        // Check if already liked
        $like = $message->likes()->where('user_id', $user->id)->first();
        
        if ($like) {
            // Unlike
            $like->delete();
            $liked = false;
        } else {
            // Like - create new like record
            $message->likes()->create([
                'user_id' => $user->id,
                'likeable_id' => $message->id,
                'likeable_type' => Message::class
            ]);
            $liked = true;
        }
        
        // Get fresh count from database
        $likesCount = $message->likes()->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}
