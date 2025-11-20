<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (!$post->is_published && (!auth()->check() || auth()->id() !== $post->user_id)) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:10000',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_published' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        
        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Post::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        $post = Post::create($validated);
        
        // Handle multiple images upload (max 10)
        if ($request->hasFile('images')) {
            $images = array_slice($request->file('images'), 0, 10); // Limit to 10 images
            foreach ($images as $index => $image) {
                $path = $image->store('post-images', 'public');
                $post->images()->create([
                    'image_path' => $path,
                    'order' => $index
                ]);
            }
        }

        return redirect()->route('post.index')->with('success', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        // Check if user can edit this post
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user can update this post
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'is_published' => 'boolean',
            'remove_images' => 'nullable|string',
        ]);

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = Str::slug($validated['title']);
            
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Post::where('slug', $validated['slug'])->where('id', '!=', $post->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // Get current images as array
        $currentImages = $post->images ? $post->images->pluck('image_path')->toArray() : [];
        
        // Handle image removal
        if ($request->has('remove_images') && !empty($request->remove_images)) {
            $removeImages = json_decode($request->remove_images, true);
            
            if (is_array($removeImages)) {
                foreach ($removeImages as $imageData) {
                    // Handle both string path and object format
                    $imagePath = is_array($imageData) ? ($imageData['image_path'] ?? null) : $imageData;
                    
                    if ($imagePath) {
                        // Delete from storage
                        \Storage::disk('public')->delete($imagePath);
                        
                        // Delete from database
                        $post->images()->where('image_path', $imagePath)->delete();
                        
                        // Remove from current array
                        $currentImages = array_values(array_filter($currentImages, function($img) use ($imagePath) {
                            return $img !== $imagePath;
                        }));
                    }
                }
            }
        }

        // Handle new images upload
        if ($request->hasFile('images')) {
            $order = count($currentImages); // Start order from current count
            
            foreach ($request->file('images') as $image) {
                if ($order >= 10) break; // Max 10 images
                
                $path = $image->store('post-images', 'public');
                
                // Create new image record
                $post->images()->create([
                    'image_path' => $path,
                    'order' => $order++
                ]);
            }
        }

        $post->update($validated);

        return redirect()->route('post.show', $post)->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        // Check if user can delete this post
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Delete featured image if exists
        if ($post->featured_image) {
            \Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();

        return redirect()->route('post.index')->with('success', 'Post deleted successfully');
    }

    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('posts.my-posts', compact('posts'));
    }
}
