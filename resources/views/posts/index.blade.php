<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog Posts') }}
            </h2>
            @auth
                <a href="{{ route('post.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create New Post
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex flex-col md:flex-row">
                            @if($post->featured_image)
                                <div class="md:w-1/3">
                                    <img 
                                        src="{{ $post->featured_image_url }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-64 md:h-full object-cover"
                                    >
                                </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex items-start gap-4">
                                    <a href="{{ route('profile.show', $post->user) }}">
                                        <img 
                                            src="{{ $post->user->avatar_url }}" 
                                            alt="{{ $post->user->name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                                        >
                                    </a>
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold mb-2">
                                            <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span>By <a href="{{ route('profile.show', $post->user) }}" class="hover:text-blue-600">{{ $post->user->name }}</a></span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            
                                            <!-- Like Button -->
                                            @auth
                                                <button 
                                                    onclick="togglePostLikeIndex({{ $post->id }})"
                                                    id="post-like-btn-index-{{ $post->id }}"
                                                    class="flex items-center gap-1 transition-colors {{ $post->isLikedBy(auth()->user()) ? 'text-red-600' : 'text-gray-500 hover:text-red-600' }}"
                                                >
                                                    <svg id="post-like-icon-{{ $post->id }}" class="w-4 h-4 {{ $post->isLikedBy(auth()->user()) ? 'fill-current' : '' }}" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    <span id="post-likes-count-index-{{ $post->id }}">{{ $post->likesCount() }}</span>
                                                </button>
                                            @else
                                                <span class="flex items-center gap-1 text-gray-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    {{ $post->likesCount() }}
                                                </span>
                                            @endauth
                                        </div>
                                        <div class="text-gray-700 prose max-w-none">
                                            {{ Str::limit(strip_tags($post->body), 300) }}
                                        </div>
                                        <a href="{{ route('post.show', $post->slug) }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                                            Read more →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No posts yet. 
                            @auth
                                <a href="{{ route('post.create') }}" class="text-blue-600 hover:text-blue-800">Create the first one!</a>
                            @endauth
                        </div>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<style>
@keyframes heartPop {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.heart-pop {
    animation: heartPop 0.3s ease-in-out;
}
</style>

<script>
function togglePostLikeIndex(postId) {
    console.log('=== POST LIKE CLICKED ===');
    console.log('Post ID:', postId);
    
    const btn = document.getElementById(`post-like-btn-index-${postId}`);
    const count = document.getElementById(`post-likes-count-index-${postId}`);
    const icon = document.getElementById(`post-like-icon-${postId}`);
    
    console.log('Elements:', { btn, count, icon });
    
    if (!btn || !count || !icon) {
        console.error('Missing elements!');
        return;
    }
    
    // Get current state
    const isLiked = btn.classList.contains('text-red-600');
    const currentCount = parseInt(count.textContent);
    
    console.log('Current state:', { isLiked, currentCount });
    
    // OPTIMISTIC UPDATE - Update UI immediately
    icon.style.transition = 'transform 0.2s ease-in-out';
    icon.style.transform = 'scale(1.3)';
    
    if (isLiked) {
        // Unlike
        btn.classList.remove('text-red-600');
        btn.classList.add('text-gray-500', 'hover:text-red-600');
        icon.setAttribute('fill', 'none');
        icon.classList.remove('fill-current');
        count.textContent = currentCount - 1;
        console.log('UI updated: UNLIKED');
    } else {
        // Like
        btn.classList.remove('text-gray-500', 'hover:text-red-600');
        btn.classList.add('text-red-600');
        icon.setAttribute('fill', 'currentColor');
        icon.classList.add('fill-current');
        count.textContent = currentCount + 1;
        console.log('UI updated: LIKED');
    }
    
    // Reset scale
    setTimeout(() => icon.style.transform = 'scale(1)', 200);
    
    // Send request in background (no waiting)
    const url = `/posts/${postId}/like`;
    console.log('Sending request to:', url);
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ SUCCESS! Server response:', data);
        // Sync with server response - ONLY update count
        count.textContent = data.likes_count;
        console.log('Count synced to:', data.likes_count);
    })
    .catch(error => {
        console.error('❌ ERROR:', error);
        // Revert on error
        if (isLiked) {
            btn.classList.add('text-red-600');
            btn.classList.remove('text-gray-500', 'hover:text-red-600');
            icon.setAttribute('fill', 'currentColor');
            icon.classList.add('fill-current');
            count.textContent = currentCount;
        } else {
            btn.classList.remove('text-red-600');
            btn.classList.add('text-gray-500', 'hover:text-red-600');
            icon.setAttribute('fill', 'none');
            icon.classList.remove('fill-current');
            count.textContent = currentCount;
        }
        console.log('UI reverted due to error');
    });
}
</script>
