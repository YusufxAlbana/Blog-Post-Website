<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get first user and first post
$user = App\Models\User::first();
$post = App\Models\Post::first();

if (!$user || !$post) {
    echo "No user or post found!\n";
    exit;
}

echo "Testing Post Like System\n";
echo "========================\n";
echo "User: {$user->name} (ID: {$user->id})\n";
echo "Post: {$post->title} (ID: {$post->id})\n\n";

// Check current likes
$currentLikes = App\Models\PostLike::where('post_id', $post->id)->count();
echo "Current likes: {$currentLikes}\n";

// Check if user already liked
$userLike = App\Models\PostLike::where('user_id', $user->id)
    ->where('post_id', $post->id)
    ->first();

if ($userLike) {
    echo "User already liked this post (Like ID: {$userLike->id})\n";
    echo "Deleting like...\n";
    $userLike->delete();
} else {
    echo "User hasn't liked this post yet\n";
    echo "Creating like...\n";
    $newLike = App\Models\PostLike::create([
        'user_id' => $user->id,
        'post_id' => $post->id
    ]);
    echo "Like created! (ID: {$newLike->id})\n";
}

// Check final count
$finalLikes = App\Models\PostLike::where('post_id', $post->id)->count();
echo "\nFinal likes: {$finalLikes}\n";

// Show all likes for this post
echo "\nAll likes for this post:\n";
$allLikes = App\Models\PostLike::where('post_id', $post->id)->get();
foreach ($allLikes as $like) {
    echo "  - User ID: {$like->user_id}, Created: {$like->created_at}\n";
}
