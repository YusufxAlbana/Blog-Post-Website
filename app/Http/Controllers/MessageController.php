<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Only show messages from OTHER users to posts owned by the logged-in user
        // Exclude messages from the logged-in user themselves
        $messages = Message::with(['post', 'user'])
            ->whereHas('post', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('is_moderated', true)
            ->where(function($query) {
                // Exclude messages from the logged-in user
                $query->where('user_id', '!=', auth()->id())
                      ->orWhereNull('user_id'); // Include guest comments
            })
            ->latest()
            ->paginate(20);

        return view('messages.index', compact('messages'));
    }
}
