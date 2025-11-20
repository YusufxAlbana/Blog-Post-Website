<?php

namespace App\Livewire;

use App\Events\MessagePosted;
use App\Models\Message;
use App\Models\Post;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class ChatBox extends Component
{
    public $post;
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'nullable|string|max:100',
        'email' => 'nullable|email',
        'message' => 'required|string|max:2000',
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        
        // Auto-fill name and email for authenticated users
        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
        }
    }

    public function send()
    {
        $this->validate();

        Message::create([
            'post_id' => $this->post->id,
            'user_id' => auth()->id(),
            'name' => $this->name ?: (auth()->check() ? auth()->user()->name : 'Anonymous'),
            'email' => $this->email ?: (auth()->check() ? auth()->user()->email : null),
            'message' => $this->message,
            'is_moderated' => true,
        ]);

        // Clear message field immediately
        $this->message = '';
        
        // Dispatch event to clear textarea
        $this->dispatch('message-sent');
    }

    public function updateMessage($messageId, $newContent)
    {
        $message = Message::findOrFail($messageId);
        
        // Check if user owns this message
        if ($message->user_id !== auth()->id()) {
            return;
        }

        // Validate new content is not empty
        if (empty(trim($newContent))) {
            return;
        }

        $message->update([
            'message' => $newContent,
        ]);

        $this->dispatch('message-updated');
    }

    public function deleteMessage($messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Check if user owns this message
        if ($message->user_id !== auth()->id()) {
            return;
        }

        $message->delete();

        $this->dispatch('message-deleted');
    }

    public function render()
    {
        // Cache messages for faster loading
        $messages = Message::with(['user' => function($query) {
                $query->select('id', 'name', 'avatar');
            }])
            ->where('post_id', $this->post->id)
            ->where('is_moderated', true)
            ->latest()
            ->limit(50)
            ->get();

        return view('livewire.chat-box', compact('messages'));
    }
}
