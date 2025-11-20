<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl gradient-text" style="background: linear-gradient(135deg, var(--accent-primary), #9D4EDD); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                {{ __('Blog') }}
            </h2>
            @auth
                <a href="{{ route('post.create') }}" style="background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary)); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Post
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-6 min-h-screen" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <div class="space-y-4 fade-in">
                @forelse($posts as $post)
                    <div class="overflow-hidden rounded-2xl transition-all cursor-pointer post-card" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);" onclick="window.location='{{ route('post.show', $post->slug) }}'">
                        <div class="p-4">
                            <div class="flex gap-3">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <a href="{{ route('profile.show', $post->user) }}" class="relative" onclick="event.stopPropagation()">
                                        <img 
                                            src="{{ $post->user->avatar_url }}" 
                                            alt="{{ $post->user->name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 hover:border-blue-500 transition-colors"
                                        >
                                        @auth
                                            @if($post->user_id != auth()->id() && !auth()->user()->isFollowing($post->user_id))
                                                <button 
                                                    onclick="event.stopPropagation(); followFromAvatar({{ $post->user->id }})"
                                                    id="follow-avatar-{{ $post->user->id }}"
                                                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-lg transition-all duration-300 transform hover:scale-110"
                                                    title="Follow {{ $post->user->name }}"
                                                >
                                                    <svg class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        </div>
                    </div>
                @endforelse

                <div class="mt-6 flex justify-center">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function followFromAvatar(userId) {
    // Find ALL follow buttons for this user (in case they have multiple posts)
    const allButtons = document.querySelectorAll(`[id^="follow-avatar-${userId}"]`);
    
    // Hide all buttons immediately
    allButtons.forEach(btn => {
        btn.style.transition = 'all 0.15s ease-out';
        btn.style.transform = 'scale(0)';
        btn.style.opacity = '0';
    });
    
    // Send request in background
    fetch(`/users/${userId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        // Remove all buttons after animation
        setTimeout(() => {
            allButtons.forEach(btn => btn.remove());
        }, 150);
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert all buttons on error
        allButtons.forEach(btn => {
            btn.style.transform = 'scale(1)';
            btn.style.opacity = '1';
        });
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
@keyframes heartPop {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.heart-pop {
    animation: heartPop 0.3s ease-in-out;
}

@keyframes followPulse {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    50% { 
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(59, 130, 246, 0.4);
    }
}

button[id^="follow-avatar-"]:hover {
    animation: followPulse 0.6s ease-in-out;
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
