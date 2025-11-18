<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessagePosted;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::with('post')->latest();

        // Filter berdasarkan status
        if ($request->filter === 'pending') {
            $query->where('is_moderated', false);
        } elseif ($request->filter === 'approved') {
            $query->where('is_moderated', true);
        }

        $messages = $query->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function approve(Message $message)
    {
        $message->update(['is_moderated' => true]);
        
        // Broadcast message setelah diapprove
        broadcast(new MessagePosted($message));

        return redirect()->back()->with('success', 'Message approved successfully');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->back()->with('success', 'Message deleted successfully');
    }
}
