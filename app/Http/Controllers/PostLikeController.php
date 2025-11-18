<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function toggle($id)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Find post by ID
        $post = Post::findOrFail($id);
        
        // Check if already liked
        $existingLike = PostLike::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $liked = false;
        } else {
            // Like
            PostLike::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $liked = true;
        }
        
        // Get fresh count
        $likesCount = PostLike::where('post_id', $post->id)->count();
        
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}
