<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="font-bold text-2xl gradient-text flex-shrink-0" style="background: linear-gradient(135deg, var(--accent-primary), #9D4EDD); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                {{ __('Blog') }}
            </h2>
            
            <!-- Search Bar -->
            <form method="GET" action="{{ route('post.index') }}" class="relative flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}"
                    placeholder="Search by title or author name..."
                    class="w-full px-4 py-2 pr-12 rounded-xl border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                    style="background: rgba(26, 26, 26, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                >
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-lg transition-all" style="color: #8A2BE2;" onmouseover="this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.transform='translateY(-50%) scale(1)'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                @if($search)
                    <a href="{{ route('post.index') }}" class="absolute right-12 top-1/2 -translate-y-1/2 p-1.5 rounded-lg transition-all" style="color: rgba(224, 224, 224, 0.6);" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='rgba(224, 224, 224, 0.6)'" title="Clear search">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                @endif
            </form>
        </div>
    </x-slot>

    <div class="py-6 min-h-screen" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <div class="flex gap-6">
                <!-- Main Content -->
                <div class="flex-1">
                    @if($search)
                        <div class="text-center mb-6">
                            <p style="color: rgba(224, 224, 224, 0.7);">
                                Showing results for "<span class="font-semibold" style="color: #8A2BE2;">{{ $search }}</span>"
                            </p>
                        </div>
                    @endif

                    <div class="space-y-4 fade-in">
                @forelse($posts as $post)
                    <div class="overflow-hidden rounded-2xl transition-all cursor-pointer post-card" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);" onclick="window.location='{{ route('post.show', $post->slug) }}'">
                        <div class="p-4">
                            <div class="flex gap-3">
                                <!-- Avatar -->
                                <div class="flex-shrink-0" style="position: relative;">
                                    <a href="{{ route('profile.show', $post->user) }}" onclick="event.stopPropagation()" style="display: block; position: relative;">
                                        <img 
                                            src="{{ $post->user->avatar_url }}" 
                                            alt="{{ $post->user->name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 transition-colors"
                                            style="border-color: rgba(138, 43, 226, 0.3); display: block;"
                                        >
                                        @auth
                                            @if($post->user_id != auth()->id() && !auth()->user()->isFollowing($post->user_id))
                                                <button 
                                                    onclick="event.stopPropagation(); event.preventDefault(); followFromAvatar({{ $post->user->id }})"
                                                    id="follow-avatar-{{ $post->user->id }}"
                                                    class="text-white rounded-full flex items-center justify-center shadow-lg transition-all duration-300"
                                                    style="position: absolute; bottom: -2px; right: -2px; width: 24px; height: 24px; background: linear-gradient(135deg, #8A2BE2, #5A189A); z-index: 10;"
                                                    onmouseover="this.style.transform='scale(1.15)'; this.style.boxShadow='0 4px 12px rgba(138, 43, 226, 0.6)'"
                                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(0, 0, 0, 0.3)'"
                                                    title="Follow {{ $post->user->name }}"
                                                >
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="pointer-events: none;">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        @endauth
                                    </a>
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <!-- Header -->
                                    <div class="flex items-center gap-2 mb-2">
                                        <a href="{{ route('profile.show', $post->user) }}" style="color: var(--text-primary);" class="font-bold hover:underline" onmouseover="this.style.color='var(--accent-primary)'" onmouseout="this.style.color='var(--text-primary)'" onclick="event.stopPropagation()">
                                            {{ $post->user->name }}
                                        </a>
                                        <span style="color: rgba(224, 224, 224, 0.5);">·</span>
                                        <span style="color: rgba(224, 224, 224, 0.6);" class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <!-- Title & Body -->
                                    <div>
                                        <h3 class="text-xl font-bold mb-2" style="color: var(--text-primary);">
                                            {{ $post->title }}
                                        </h3>
                                        <div class="mb-3" style="color: rgba(224, 224, 224, 0.8);">
                                            {{ Str::limit(strip_tags($post->body), 200) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Images Carousel -->
                                    @if($post->images->count() > 0)
                                        <div class="mb-3 rounded-2xl overflow-hidden relative bg-black" style="border: 2px solid rgba(138, 43, 226, 0.3);">
                                            <div class="overflow-hidden">
                                                <div class="flex transition-transform duration-300 ease-in-out" id="carousel-{{ $post->id }}">
                                                    @foreach($post->images as $image)
                                                        <div class="w-full flex-shrink-0 flex items-center justify-center" style="height: 400px;">
                                                            <img 
                                                                src="{{ $image->image_url }}" 
                                                                alt="{{ $post->title }}"
                                                                class="max-w-full max-h-full object-contain"
                                                            >
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            @if($post->images->count() > 1)
                                                <!-- Navigation Buttons -->
                                                <button onclick="event.stopPropagation(); prevSlide({{ $post->id }}, {{ $post->images->count() }})" class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full p-2 shadow-lg transition-all" style="background: rgba(138, 43, 226, 0.9); color: white; border: 2px solid rgba(138, 43, 226, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 1)'; this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.9)'; this.style.transform='translateY(-50%) scale(1)'">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                    </svg>
                                                </button>
                                                <button onclick="event.stopPropagation(); nextSlide({{ $post->id }}, {{ $post->images->count() }})" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full p-2 shadow-lg transition-all" style="background: rgba(138, 43, 226, 0.9); color: white; border: 2px solid rgba(138, 43, 226, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 1)'; this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.9)'; this.style.transform='translateY(-50%) scale(1)'">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </button>
                                                
                                                <!-- Indicators -->
                                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                                                    @foreach($post->images as $index => $image)
                                                        <div class="w-2 h-2 rounded-full transition-all {{ $index === 0 ? 'opacity-100' : 'opacity-50' }}" style="background: #8A2BE2;" data-indicator-{{ $post->id }}="{{ $index }}"></div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center gap-6 text-gray-500">
                                        <!-- Comment Count -->
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <span>{{ $post->messages()->where('is_moderated', true)->count() }}</span>
                                        </div>
                                        
                                        <!-- Like Button -->
                                        @auth
                                                <button 
                                                    onclick="event.stopPropagation(); togglePostLikeIndex({{ $post->id }})"
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
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="overflow-hidden shadow-sm rounded-2xl" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);">
                        <div class="p-12 text-center">
                            @if($search)
                                <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">No posts found</h3>
                                <p class="mb-4" style="color: rgba(224, 224, 224, 0.6);">No posts match your search for "{{ $search }}"</p>
                                <a href="{{ route('post.index') }}" class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                                    Clear Search
                                </a>
                            @else
                                <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                                <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">No posts yet</h3>
                                <p class="mb-4" style="color: rgba(224, 224, 224, 0.6);">Be the first to share something!</p>
                                @auth
                                    <a href="{{ route('post.create') }}" class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Post
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                @endforelse

                @if($posts->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $posts->appends(['search' => $search])->links() }}
                    </div>
                @endif
                    </div>
                </div>

                <!-- Right Sidebar - Top 5 Most Liked Posts -->
                <div class="w-80 flex-shrink-0 hidden xl:block">
                    <div class="sticky top-6">
                        <div class="rounded-2xl p-6" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);">
                            <h3 class="text-lg font-bold mb-4 flex items-center gap-2" style="color: #E0E0E0;">
                                <svg class="w-5 h-5" style="color: #8A2BE2;" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                Most Liked Posts
                            </h3>
                            
                            @php
                                $topPosts = \App\Models\Post::where('is_published', true)
                                    ->withCount('likes')
                                    ->orderBy('likes_count', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            
                            <div class="space-y-3">
                                @forelse($topPosts as $index => $topPost)
                                    <a href="{{ route('post.show', $topPost->slug) }}" class="block p-3 rounded-xl transition-all" style="background: rgba(138, 43, 226, 0.05); border: 1px solid rgba(138, 43, 226, 0.1);" onmouseover="this.style.background='rgba(138, 43, 226, 0.15)'; this.style.borderColor='rgba(138, 43, 226, 0.3)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.05)'; this.style.borderColor='rgba(138, 43, 226, 0.1)'">
                                        <div class="flex gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-sm mb-1 line-clamp-2" style="color: #E0E0E0;">
                                                    {{ $topPost->title }}
                                                </h4>
                                                <div class="flex items-center gap-3 text-xs" style="color: rgba(224, 224, 224, 0.6);">
                                                    <span>by {{ $topPost->user->name }}</span>
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                        </svg>
                                                        {{ $topPost->likes_count }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-center py-4 text-sm" style="color: rgba(224, 224, 224, 0.5);">No posts yet</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function followFromAvatar(userId) {
    console.log('Follow button clicked for user:', userId);
    
    // Find ALL follow buttons for this user (in case they have multiple posts)
    const allButtons = document.querySelectorAll(`#follow-avatar-${userId}`);
    
    console.log('Found buttons:', allButtons.length);
    
    // Animate all buttons immediately
    allButtons.forEach(btn => {
        btn.style.transition = 'all 0.3s ease-out';
        btn.style.transform = 'scale(0) rotate(180deg)';
        btn.style.opacity = '0';
        btn.disabled = true;
    });
    
    // Send follow request
    fetch(`/users/${userId}/follow`, {
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
        console.log('✅ Follow SUCCESS:', data);
        // Remove all buttons after animation completes
        setTimeout(() => {
            allButtons.forEach(btn => {
                if (btn && btn.parentNode) {
                    btn.remove();
                }
            });
        }, 300);
    })
    .catch(error => {
        console.error('❌ Follow ERROR:', error);
        // Revert all buttons on error
        allButtons.forEach(btn => {
            btn.style.transform = 'scale(1) rotate(0deg)';
            btn.style.opacity = '1';
            btn.disabled = false;
        });
        alert('Failed to follow user. Please try again.');
    });
}

// Carousel for blog index
const carouselStates = {};

function initCarousel(postId) {
    if (!carouselStates[postId]) {
        carouselStates[postId] = 0;
    }
}

function updateCarousel(postId, totalImages) {
    const carousel = document.getElementById(`carousel-${postId}`);
    const indicators = document.querySelectorAll(`[data-indicator-${postId}]`);
    
    if (carousel) {
        carousel.style.transform = `translateX(-${carouselStates[postId] * 100}%)`;
        
        indicators.forEach((indicator, index) => {
            if (index === carouselStates[postId]) {
                indicator.classList.remove('opacity-50');
                indicator.classList.add('opacity-100');
            } else {
                indicator.classList.remove('opacity-100');
                indicator.classList.add('opacity-50');
            }
        });
    }
}

function nextSlide(postId, totalImages) {
    initCarousel(postId);
    if (carouselStates[postId] < totalImages - 1) {
        carouselStates[postId]++;
        updateCarousel(postId, totalImages);
    }
}

function prevSlide(postId, totalImages) {
    initCarousel(postId);
    if (carouselStates[postId] > 0) {
        carouselStates[postId]--;
        updateCarousel(postId, totalImages);
    }
}
</script>

<style>
.post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(138, 43, 226, 0.15);
    border-color: #8A2BE2 !important;
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
