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

        $msg = Message::create([
            'post_id' => $this->post->id,
            'user_id' => auth()->id(),
            'name' => $this->name ?: (auth()->check() ? auth()->user()->name : 'Anonymous'),
            'email' => $this->email ?: (auth()->check() ? auth()->user()->email : null),
            'message' => $this->message,
            'is_moderated' => true, // Auto approve for faster response
        ]);

        // Clear message field immediately
        $this->reset('message');
        
        // Dispatch event to clear textarea
        $this->dispatch('message-sent');
    }

    public function render()
    {
        $messages = Message::with('user')
            ->where('post_id', $this->post->id)
            ->where('is_moderated', true)
            ->latest()
            ->take(50)
            ->get();

        return view('livewire.chat-box', compact('messages'));
    }
}
