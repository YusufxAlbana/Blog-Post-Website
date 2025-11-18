<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileViewController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->where('is_published', true)
            ->latest()
            ->paginate(10);

        return view('profile.show', compact('user', 'posts'));
    }
}
