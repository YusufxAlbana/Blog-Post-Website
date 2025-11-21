<x-app-layout>
    <div class="py-12">
        <div class="px-6 space-y-6">
            
            <!-- Main Content Card -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <!-- Author Info & Edit/Delete Buttons -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <a href="{{ route('profile.show', $post->user) }}">
                                    <img 
                                        src="{{ $post->user->avatar_url }}" 
                                        alt="{{ $post->user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2"
                                        style="border-color: rgba(138, 43, 226, 0.5); {{ $post->user->isAnonymous() ? 'padding: 4px; background: linear-gradient(135deg, #8A2BE2, #5A189A);' : '' }}"
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
                                <a href="{{ route('profile.show', $post->user) }}" class="font-semibold transition-colors" style="color: #E0E0E0;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#E0E0E0'">
                                    {{ $post->user->name }}
                                </a>
                                <p class="text-sm" style="color: #9CA3AF;">{{ $post->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                        
                        <!-- Edit/Delete Buttons -->
                        @auth
                            @if(auth()->id() === $post->user_id || Auth::user()->isAdmin())
                                <div class="flex gap-2">
                                    <a href="{{ route('post.edit', $post->slug) }}" class="p-2 rounded-lg transition-all" style="background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(202, 138, 4, 0.3)); color: #FCD34D; border: 1px solid rgba(234, 179, 8, 0.5); box-shadow: 0 0 15px rgba(234, 179, 8, 0.2);" onmouseover="this.style.background='linear-gradient(135deg, rgba(234, 179, 8, 0.4), rgba(202, 138, 4, 0.4))'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 0 20px rgba(234, 179, 8, 0.4)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(202, 138, 4, 0.3))'; this.style.transform=''; this.style.boxShadow='0 0 15px rgba(234, 179, 8, 0.2)'" title="Edit Post">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('post.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg transition-all" style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(185, 28, 28, 0.3)); color: #FCA5A5; border: 1px solid rgba(220, 38, 38, 0.5); box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);" onmouseover="this.style.background='linear-gradient(135deg, rgba(220, 38, 38, 0.4), rgba(185, 28, 28, 0.4))'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 0 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(185, 28, 28, 0.3))'; this.style.transform=''; this.style.boxShadow='0 0 15px rgba(220, 38, 38, 0.2)'" title="Delete Post">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold mb-4" style="color: #E0E0E0;">{{ $post->title }}</h1>

                    <!-- Post Body -->
                    <div class="prose max-w-none mb-6" style="color: #E0E0E0;">
                        {!! nl2br(e($post->body)) !!}
                    </div>

                    <!-- Like Button -->
                    <div class="flex justify-end mb-6">
                        @auth
                            <button 
                                onclick="togglePostLike({{ $post->id }})"
                                id="post-like-btn-{{ $post->id }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-lg transition-all"
                                style="{{ $post->isLikedBy(auth()->user()) ? 'background: rgba(220, 38, 38, 0.2); color: #EF4444; border: 1px solid rgba(220, 38, 38, 0.3);' : 'background: rgba(138, 43, 226, 0.1); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.2);' }}"
                            >
                                <svg id="post-like-icon-{{ $post->id }}" class="w-5 h-5 {{ $post->isLikedBy(auth()->user()) ? 'fill-current' : '' }}" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="post-likes-count-{{ $post->id }}">{{ $post->likesCount() }}</span>
                            </button>
                        @else
                            <div class="flex items-center gap-2 px-4 py-2 rounded-lg" style="background: rgba(138, 43, 226, 0.1); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.2);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>{{ $post->likesCount() }}</span>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Images Section -->
                @if($post->images->count() > 0)
                    <!-- Image Gallery Carousel -->
                    <div class="relative rounded-lg overflow-hidden" style="background: #000; border: 2px solid rgba(138, 43, 226, 0.3);" id="image-gallery">
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
                            <button onclick="previousImage()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full p-3 shadow-lg transition-all" style="background: rgba(138, 43, 226, 0.9); color: white; border: 2px solid rgba(138, 43, 226, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 1)'; this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.9)'; this.style.transform='translateY(-50%) scale(1)'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full p-3 shadow-lg transition-all" style="background: rgba(138, 43, 226, 0.9); color: white; border: 2px solid rgba(138, 43, 226, 0.5);" onmouseover="this.style.background='rgba(138, 43, 226, 1)'; this.style.transform='translateY(-50%) scale(1.1)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.9)'; this.style.transform='translateY(-50%) scale(1)'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                @foreach($post->images as $index => $image)
                                    <div class="w-2 h-2 rounded-full transition-all {{ $index === 0 ? 'opacity-100' : 'opacity-50' }}" style="background: #8A2BE2;" data-indicator="{{ $index }}"></div>
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
            </div>

            <!-- Chat Box Component -->
            @livewire('chat-box', ['post' => $post])
        </div>
    </div>
</x-app-layout>

<script>
function followFromAvatar(userId) {
    const allButtons = document.querySelectorAll(`[id^="follow-avatar-${userId}"]`);
    allButtons.forEach(btn => {
        btn.style.transition = 'all 0.15s ease-out';
        btn.style.transform = 'scale(0)';
        btn.style.opacity = '0';
    });
    
    fetch(`/users/${userId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        setTimeout(() => allButtons.forEach(btn => btn.remove()), 150);
    })
    .catch(error => {
        console.error('Error:', error);
        allButtons.forEach(btn => {
            btn.style.transform = 'scale(1)';
            btn.style.opacity = '1';
        });
    });
}

function togglePostLike(postId) {
    const btn = document.getElementById(`post-like-btn-${postId}`);
    const count = document.getElementById(`post-likes-count-${postId}`);
    const icon = document.getElementById(`post-like-icon-${postId}`);
    
    if (!btn || !count || !icon) return;
    
    const isLiked = btn.style.background.includes('220, 38, 38');
    const currentCount = parseInt(count.textContent);
    
    icon.classList.add('heart-animate');
    
    if (isLiked) {
        btn.style.background = 'rgba(138, 43, 226, 0.1)';
        btn.style.color = '#E0E0E0';
        btn.style.border = '1px solid rgba(138, 43, 226, 0.2)';
        icon.setAttribute('fill', 'none');
        icon.classList.remove('fill-current');
        count.textContent = currentCount - 1;
    } else {
        btn.style.background = 'rgba(220, 38, 38, 0.2)';
        btn.style.color = '#EF4444';
        btn.style.border = '1px solid rgba(220, 38, 38, 0.3)';
        icon.setAttribute('fill', 'currentColor');
        icon.classList.add('fill-current');
        count.textContent = currentCount + 1;
    }
    
    setTimeout(() => icon.classList.remove('heart-animate'), 500);
    
    fetch(`/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        count.textContent = data.likes_count;
    })
    .catch(error => {
        console.error('Error:', error);
        if (isLiked) {
            btn.style.background = 'rgba(220, 38, 38, 0.2)';
            btn.style.color = '#EF4444';
            btn.style.border = '1px solid rgba(220, 38, 38, 0.3)';
            icon.setAttribute('fill', 'currentColor');
            icon.classList.add('fill-current');
            count.textContent = currentCount;
        } else {
            btn.style.background = 'rgba(138, 43, 226, 0.1)';
            btn.style.color = '#E0E0E0';
            btn.style.border = '1px solid rgba(138, 43, 226, 0.2)';
            icon.setAttribute('fill', 'none');
            icon.classList.remove('fill-current');
            count.textContent = currentCount;
        }
    });
}

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

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') previousImage();
    if (e.key === 'ArrowRight') nextImage();
});
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
</style>
