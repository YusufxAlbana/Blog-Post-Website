<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Message on Your Blog')
            ->line('You have received a new message on your blog post.')
            ->line('From: ' . ($this->message->name ?? 'Anonymous'))
            ->line('Email: ' . ($this->message->email ?? 'Not provided'))
            ->line('Message: ' . $this->message->message)
            ->action('View Post', route('post.show', $this->message->post->slug))
            ->line('Thank you for using our application!');
    }
}
