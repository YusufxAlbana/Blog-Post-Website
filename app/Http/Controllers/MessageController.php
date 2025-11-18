<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('post')
            ->where('is_moderated', true)
            ->latest()
            ->paginate(20);

        return view('messages.index', compact('messages'));
    }
}
