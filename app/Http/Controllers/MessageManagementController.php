<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageManagementController extends Controller
{
    public function update(Request $request, Message $message)
    {
        // Check if user owns this message
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'nullable|string|max:2000'
        ]);

        // Only update if message is provided
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

    public function destroy(Message $message)
    {
        // Check if user owns this message
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
