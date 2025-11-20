<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();
        
        return view('direct-messages.index', compact('conversations'));
    }
    
    public function show($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUserId = auth()->id();
        
        // Find or create conversation
        $conversation = Conversation::where(function($query) use ($currentUserId, $userId) {
            $query->where('user_one_id', $currentUserId)->where('user_two_id', $userId);
        })->orWhere(function($query) use ($currentUserId, $userId) {
            $query->where('user_one_id', $userId)->where('user_two_id', $currentUserId);
        })->first();
        
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => min($currentUserId, $userId),
                'user_two_id' => max($currentUserId, $userId),
            ]);
        }
        
        // Mark messages as read
        DirectMessage::where('conversation_id', $conversation->id)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        
        return view('direct-messages.show', compact('conversation', 'messages', 'otherUser'));
    }
    
    public function store(Request $request, $userId)
    {
        $request->validate([
            'message' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);
        
        // At least one of message or image must be present
        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['error' => 'Message or image required'], 422);
        }
        
        $currentUserId = auth()->id();
        
        // Find or create conversation
        $conversation = Conversation::where(function($query) use ($currentUserId, $userId) {
            $query->where('user_one_id', $currentUserId)->where('user_two_id', $userId);
        })->orWhere(function($query) use ($currentUserId, $userId) {
            $query->where('user_one_id', $userId)->where('user_two_id', $currentUserId);
        })->first();
        
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => min($currentUserId, $userId),
                'user_two_id' => max($currentUserId, $userId),
            ]);
        }
        
        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $currentUserId,
            'message' => $request->message ?? '',
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chat-images', 'public');
            $data['image'] = $path;
        }
        
        $message = DirectMessage::create($data);
        
        $conversation->update(['last_message_at' => now()]);
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'image_url' => $message->image_url
        ]);
    }

    public function update(Request $request, DirectMessage $message)
    {
        // Check if user owns this message
        if ($message->sender_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'nullable|string|max:2000'
        ]);

        // Only update if message text is provided
        if ($request->has('message')) {
            $message->update([
                'message' => $request->message
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $message->message
        ]);
    }

    public function destroy(DirectMessage $message)
    {
        // Check if user owns this message
        if ($message->sender_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
