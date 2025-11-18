<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
            ]);
        }

        $posts = [
            [
                'title' => 'Welcome to My Blog',
                'body' => "Hello and welcome to my personal blog! This is my first post where I'll be sharing my thoughts, experiences, and insights on various topics.\n\nI'm excited to start this journey and connect with readers who share similar interests. Stay tuned for more content!",
            ],
            [
                'title' => 'Getting Started with Laravel',
                'body' => "Laravel is an amazing PHP framework that makes web development a breeze. In this post, I'll share some tips and tricks I've learned while building applications with Laravel.\n\nFrom routing to Eloquent ORM, Laravel provides elegant solutions to common web development challenges. The documentation is excellent and the community is very supportive.\n\nIf you're new to Laravel, I highly recommend starting with the official documentation and building small projects to practice.",
            ],
            [
                'title' => 'The Power of Real-Time Features',
                'body' => "Real-time features can transform user experience in web applications. Whether it's live chat, notifications, or collaborative editing, real-time functionality adds a dynamic layer to your app.\n\nWith Laravel Echo and broadcasting, implementing real-time features has never been easier. You can use Pusher for a managed solution or set up your own WebSocket server.\n\nThe key is to start simple and gradually add more complex real-time interactions as your application grows.",
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'body' => $postData['body'],
                'slug' => Str::slug($postData['title']),
                'is_published' => true,
            ]);
        }
    }
}
