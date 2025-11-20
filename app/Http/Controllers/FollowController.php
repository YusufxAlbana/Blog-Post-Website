<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $currentUser = auth()->user();
        
        // Cannot follow yourself
        if ($currentUser->id === $user->id) {
            return response()->json(['error' => 'Cannot follow yourself'], 400);
        }
        
        if ($currentUser->isFollowing($user->id)) {
            // Unfollow
            $currentUser->following()->detach($user->id);
            $following = false;
        } else {
            // Follow
            $currentUser->following()->attach($user->id);
            $following = true;
        }
        
        return response()->json([
            'following' => $following,
            'followers_count' => $user->followersCount()
        ]);
    }

    public function following()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');
        
        // Posts from people you follow
        $posts = Post::whereIn('user_id', $followingIds)
            ->where('is_published', true)
            ->with(['user', 'images', 'likes'])
            ->latest()
            ->get();
        
        // All posts for "For you" tab
        $allPosts = Post::where('is_published', true)
            ->with(['user', 'images', 'likes'])
            ->latest()
            ->take(20)
            ->get();
        
        return view('following.index', compact('posts', 'allPosts'));
    }

    public function followingList(Request $request)
    {
        $search = $request->input('search');
        
        $following = auth()->user()->following()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(20);
        
        return view('following.list', compact('following', 'search'));
    }

    public function followersList(Request $request)
    {
        $search = $request->input('search');
        
        $followers = auth()->user()->followers()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(20);
        
        return view('followers.list', compact('followers', 'search'));
    }
}
