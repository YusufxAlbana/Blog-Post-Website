<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/profile/{user}', [\App\Http\Controllers\ProfileViewController::class, 'show'])->name('profile.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return redirect()->route('profile.show', auth()->user());
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Messages for regular users
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    
    // Like routes
    Route::post('/posts/{post}/like', [\App\Http\Controllers\LikeController::class, 'togglePostLike'])->name('post.like');
    Route::post('/messages/{message}/like', [\App\Http\Controllers\LikeController::class, 'toggleMessageLike'])->name('message.like');
    
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
