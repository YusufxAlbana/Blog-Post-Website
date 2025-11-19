<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Only show messages from posts owned by the logged-in user
        $messages = Message::with('post')
            ->whereHas('post', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('is_moderated', true)
            ->latest()
            ->paginate(20);

        return view('messages.index', compact('messages'));
    }
}
