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
    }

    public function send()
    {
        $this->validate();

        $msg = Message::create([
            'post_id' => $this->post->id,
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'is_moderated' => config('blog.moderate_messages', false) ? false : true,
        ]);

        if (config('blog.moderate_messages', false) === false) {
            broadcast(new MessagePosted($msg));
        }

        // Send email notification
        if (config('mail.admin_address')) {
            Notification::route('mail', config('mail.admin_address'))
                ->notify(new NewMessageNotification($msg));
        }

        $this->reset('message');
        $this->dispatch('messageSent');
        
        session()->flash('message', 'Message sent successfully!');
    }

    public function render()
    {
        $messages = Message::where('post_id', $this->post->id)
            ->where('is_moderated', true)
            ->latest()
            ->take(50)
            ->get();

        return view('livewire.chat-box', compact('messages'));
    }
}
