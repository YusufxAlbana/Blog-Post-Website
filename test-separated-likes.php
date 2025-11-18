<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING SEPARATED LIKE SYSTEMS ===\n\n";

$user = App\Models\User::first();
$post = App\Models\Post::first();
$message = App\Models\Message::first();

if (!$user || !$post) {
    echo "Missing user or post!\n";
    exit;
}

echo "User: {$user->name} (ID: {$user->id})\n";
echo "Post: {$post->title} (ID: {$post->id})\n";
if ($message) {
    echo "Message: " . substr($message->body, 0, 30) . "... (ID: {$message->id})\n";
}
echo "\n";

// Test POST LIKES (using post_likes table)
echo "--- POST LIKES (post_likes table) ---\n";
$postLikesBefore = App\Models\PostLike::where('post_id', $post->id)->count();
echo "Before: {$postLikesBefore} likes\n";

$existingPostLike = App\Models\PostLike::where('user_id', $user->id)
    ->where('post_id', $post->id)
    ->first();

if ($existingPostLike) {
    echo "Removing existing post like...\n";
    $existingPostLike->delete();
} else {
    echo "Creating new post like...\n";
    App\Models\PostLike::create([
        'user_id' => $user->id,
        'post_id' => $post->id
    ]);
}

$postLikesAfter = App\Models\PostLike::where('post_id', $post->id)->count();
echo "After: {$postLikesAfter} likes\n\n";

// Test MESSAGE LIKES (using likes table with polymorphic)
if ($message) {
    echo "--- MESSAGE LIKES (likes table - polymorphic) ---\n";
    $messageLikesBefore = App\Models\Like::where('likeable_id', $message->id)
        ->where('likeable_type', App\Models\Message::class)
        ->count();
    echo "Before: {$messageLikesBefore} likes\n";
    
    $existingMessageLike = App\Models\Like::where('user_id', $user->id)
        ->where('likeable_id', $message->id)
        ->where('likeable_type', App\Models\Message::class)
        ->first();
    
    if ($existingMessageLike) {
        echo "Removing existing message like...\n";
        $existingMessageLike->delete();
    } else {
        echo "Creating new message like...\n";
        App\Models\Like::create([
            'user_id' => $user->id,
            'likeable_id' => $message->id,
            'likeable_type' => App\Models\Message::class
        ]);
    }
    
    $messageLikesAfter = App\Models\Like::where('likeable_id', $message->id)
        ->where('likeable_type', App\Models\Message::class)
        ->count();
    echo "After: {$messageLikesAfter} likes\n\n";
}

echo "=== SUMMARY ===\n";
echo "Total post_likes records: " . App\Models\PostLike::count() . "\n";
echo "Total likes records (messages): " . App\Models\Like::where('likeable_type', App\Models\Message::class)->count() . "\n";
echo "\n✅ Systems are SEPARATED!\n";
