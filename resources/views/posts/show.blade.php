<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
            @auth
                @if(auth()->id() === $post->user_id || Auth::user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('post.edit', $post->slug) }}" class="p-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700" title="Edit Post">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('post.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700" title="Delete Post">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($post->images->count() > 0)
                    <!-- Image Gallery Carousel -->
                    <div class="relative bg-black" id="image-gallery">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-300 ease-in-out" id="gallery-track">
                                @foreach($post->images as $image)
                                    <div class="w-full flex-shrink-0 flex items-center justify-center" style="min-height: 400px; max-height: 600px;">
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
                            <button onclick="previousImage()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="nextImage()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 shadow-lg transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                @foreach($post->images as $index => $image)
                                    <div class="w-2 h-2 rounded-full bg-white transition-all {{ $index === 0 ? 'opacity-100' : 'opacity-50' }}" data-indicator="{{ $index }}"></div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @elseif($post->featured_image)
                    <img 
                        src="{{ $post->featured_image_url }}" 
                        alt="{{ $post->title }}"
                        class="w-full h-96 object-cover"
                    >
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <a href="{{ route('profile.show', $post->user) }}">
                                    <img 
                                        src="{{ $post->user->avatar_url }}" 
                                        alt="{{ $post->user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                                    >
                                </a>
                                @auth
                                    @if($post->user_id != auth()->id() && !auth()->user()->isFollowing($post->user_id))
                                        <button 
                                            onclick="followFromAvatar({{ $post->user->id }})"
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
                            </div>
                            <div>
                                <a href="{{ route('profile.show', $post->user) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                    {{ $post->user->name }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $post->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                        
                        <!-- Like Button -->
                        @auth
                            <button 
                                onclick="togglePostLike({{ $post->id }})"
                                id="post-like-btn-{{ $post->id }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg transition-colors {{ $post->isLikedBy(auth()->user()) ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                            >
                                <svg id="post-like-icon-{{ $post->id }}" class="w-5 h-5 {{ $post->isLikedBy(auth()->user()) ? 'fill-current' : '' }}" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="post-likes-count-{{ $post->id }}">{{ $post->likesCount() }}</span>
                            </button>
                        @else
                            <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>{{ $post->likesCount() }}</span>
                            </div>
                        @endauth
                    </div>
                    
                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($post->body)) !!}
                    </div>
                </div>
            </div>

            <!-- Chat Box Component -->
            @livewire('chat-box', ['post' => $post])
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
</script>

<style>
@keyframes heartBeat {
    0% { transform: scale(1); }
    25% { transform: scale(1.3); }
    50% { transform: scale(1.1); }
    75% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.heart-animate {
    animation: heartBeat 0.5s ease-in-out;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.pulse-animate {
    animation: pulse 0.3s ease-in-out;
}
</style>

<script>
function togglePostLike(postId) {
    console.log('=== POST LIKE CLICKED (DETAIL) ===');
    console.log('Post ID:', postId);
    
    const btn = document.getElementById(`post-like-btn-${postId}`);
    const count = document.getElementById(`post-likes-count-${postId}`);
    const icon = document.getElementById(`post-like-icon-${postId}`);
    
    console.log('Elements:', { btn, count, icon });
    
    if (!btn || !count || !icon) {
        console.error('Missing elements!');
        return;
    }
    
    // Get current state
    const isLiked = btn.classList.contains('bg-red-100');
    const currentCount = parseInt(count.textContent);
    
    console.log('Current state:', { isLiked, currentCount });
    
    // OPTIMISTIC UPDATE - Update UI immediately
    icon.classList.add('heart-animate');
    
    if (isLiked) {
        // Unlike
        btn.classList.remove('bg-red-100', 'text-red-600');
        btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
        icon.setAttribute('fill', 'none');
        icon.classList.remove('fill-current');
        count.textContent = currentCount - 1;
        console.log('UI updated: UNLIKED');
    } else {
        // Like
        btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
        btn.classList.add('bg-red-100', 'text-red-600');
        icon.setAttribute('fill', 'currentColor');
        icon.classList.add('fill-current');
        count.textContent = currentCount + 1;
        console.log('UI updated: LIKED');
    }
    
    // Remove animation class
    setTimeout(() => icon.classList.remove('heart-animate'), 500);
    
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
            btn.classList.add('bg-red-100', 'text-red-600');
            btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
            icon.setAttribute('fill', 'currentColor');
            icon.classList.add('fill-current');
            count.textContent = currentCount;
        } else {
            btn.classList.remove('bg-red-100', 'text-red-600');
            btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
            icon.setAttribute('fill', 'none');
            icon.classList.remove('fill-current');
            count.textContent = currentCount;
        }
        console.log('UI reverted due to error');
    });
}
</script>


<script>
// Image Gallery Carousel
let currentImageIndex = 0;
const totalImages = {{ $post->images->count() ?? 0 }};

function updateGallery() {
    const track = document.getElementById('gallery-track');
    const indicators = document.querySelectorAll('[data-indicator]');
    
    if (track) {
        track.style.transform = `translateX(-${currentImageIndex * 100}%)`;
        
        indicators.forEach((indicator, index) => {
            if (index === currentImageIndex) {
                indicator.classList.remove('opacity-50');
                indicator.classList.add('opacity-100');
            } else {
                indicator.classList.remove('opacity-100');
                indicator.classList.add('opacity-50');
            }
        });
    }
}

function nextImage() {
    if (currentImageIndex < totalImages - 1) {
        currentImageIndex++;
        updateGallery();
    }
}

function previousImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        updateGallery();
    }
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') previousImage();
    if (e.key === 'ArrowRight') nextImage();
});
</script>
