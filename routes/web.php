<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/profile/{user}', [\App\Http\Controllers\ProfileViewController::class, 'show'])->name('profile.show');

// Test route for debugging likes
Route::get('/test-like', function() {
    $post = \App\Models\Post::first();
    $user = \App\Models\User::find(2);
    
    if (!$post || !$user) {
        return 'Post or User not found';
    }
    
    // Try to create like
    $like = \App\Models\Like::create([
        'user_id' => $user->id,
        'likeable_id' => $post->id,
        'likeable_type' => get_class($post)
    ]);
    
    return [
        'like_id' => $like->id,
        'user_id' => $like->user_id,
        'likeable_id' => $like->likeable_id,
        'likeable_type' => $like->likeable_type,
        'total_likes' => $post->likes()->count()
    ];
});

// Redirect dashboard to blog index
Route::get('/dashboard', function () {
    return redirect()->route('post.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return redirect()->route('profile.show', auth()->user());
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Messages for regular users
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    
    // Follow routes
    Route::post('/users/{user}/follow', [\App\Http\Controllers\FollowController::class, 'toggle'])->name('user.follow');
    Route::get('/following', [\App\Http\Controllers\FollowController::class, 'following'])->name('following.index');
    
    // Like routes - SEPARATED (using ID not slug)
    Route::post('/posts/{id}/like', [\App\Http\Controllers\PostLikeController::class, 'toggle'])->name('post.like')->where('id', '[0-9]+');
    Route::post('/messages/{message}/like', [\App\Http\Controllers\LikeController::class, 'toggleMessageLike'])->name('message.like');
    
    // Direct Messages (Inbox)
    Route::get('/inbox', [\App\Http\Controllers\DirectMessageController::class, 'index'])->name('dm.index');
    Route::get('/inbox/{user}', [\App\Http\Controllers\DirectMessageController::class, 'show'])->name('dm.show');
    Route::post('/inbox/{user}', [\App\Http\Controllers\DirectMessageController::class, 'store'])->name('dm.store');
    
    // Message management routes
    Route::patch('/messages/{message}', [\App\Http\Controllers\MessageManagementController::class, 'update'])->name('message.update');
    Route::delete('/messages/{message}', [\App\Http\Controllers\MessageManagementController::class, 'destroy'])->name('message.destroy');
    
    // Post management routes (all authenticated users)
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('post.myPosts');
    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/posts/{post:slug}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->name('post.destroy');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
        Route::patch('/messages/{message}/approve', [\App\Http\Controllers\Admin\MessageController::class, 'approve'])->name('messages.approve');
        Route::delete('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
        
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.updateRole');
    });
});

require __DIR__.'/auth.php';
