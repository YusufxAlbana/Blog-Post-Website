<x-app-layout>
    <div class="py-0 min-h-screen" style="background-color: var(--bg-primary);">
        <!-- Sticky Navbar with Tabs and Search -->
        <div class="sticky top-0 z-40 navbar-tabs" style="background: rgba(13, 13, 13, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(138, 43, 226, 0.2); transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;">
            <div class="flex gap-6 px-6">
                <!-- Tabs (Left) -->
                <div class="flex-1 max-w-2xl">
                    <div class="flex">
                        <button 
                            onclick="switchTab('foryou')"
                            id="tab-foryou"
                            class="flex-1 py-4 font-semibold transition-all relative tab-button"
                            style="color: #E0E0E0;"
                        >
                            For you
                            <div class="tab-indicator" style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #8A2BE2; border-radius: 3px 3px 0 0;"></div>
                        </button>
                        <button 
                            onclick="switchTab('following')"
                            id="tab-following"
                            class="flex-1 py-4 font-semibold transition-all relative tab-button"
                            style="color: #6B7280;"
                        >
                            Following
                        </button>
                    </div>
                </div>
                
                <!-- Search Bar (Right) -->
                <div class="w-80 flex-shrink-0 py-3">
                    <form method="GET" action="{{ route('post.index') }}" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search posts or users..."
                            class="w-full px-4 py-3 pl-12 rounded-full border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                            style="background: rgba(26, 26, 26, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                        >
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5" style="color: #6B7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('post.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 p-1 rounded-full transition-all" style="color: #6B7280;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#6B7280'" title="Clear search">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="flex gap-6 px-6 pt-4">
            <!-- Main Content -->
            <div class="flex-1 max-w-2xl">

                <!-- For You Content -->
                <div id="content-foryou" class="tab-content">
                    <div class="space-y-4 py-4">
                        @forelse($posts as $post)
                            @include('partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-12">
                                <p style="color: #9CA3AF;">No posts available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Following Content -->
                <div id="content-following" class="tab-content hidden">
                    <div class="space-y-4 py-4">
                        @forelse($followingPosts as $post)
                            @include('partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">You're not following anyone yet</h3>
                                <p class="mb-4" style="color: #9CA3AF;">Follow users to see their posts here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="w-80 flex-shrink-0 py-4">
                <!-- Most Liked Posts -->
                <div class="rounded-2xl p-4" style="background: rgba(26, 26, 26, 0.8); border: 1px solid rgba(138, 43, 226, 0.2);">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5" style="color: #8A2BE2;" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                        </svg>
                        <h3 class="text-xl font-bold" style="color: #E0E0E0;">Most Liked Posts</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @forelse($mostLikedPosts as $index => $post)
                            <a href="{{ route('post.show', $post->slug) }}" class="block py-3 cursor-pointer transition-all rounded-lg px-2" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0">
                                        <span class="text-2xl font-bold" style="color: rgba(138, 43, 226, 0.5);">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <img 
                                                src="{{ $post->user->avatar_url }}" 
                                                alt="{{ $post->user->name }}"
                                                class="w-5 h-5 rounded-full object-cover"
                                            >
                                            <p class="text-xs truncate" style="color: #6B7280;">{{ $post->user->name }}</p>
                                        </div>
                                        <p class="font-semibold mb-1 line-clamp-2" style="color: #E0E0E0;">{{ $post->title }}</p>
                                        <div class="flex items-center gap-1 text-xs" style="color: #6B7280;">
                                            <svg class="w-3 h-3 fill-current text-red-500" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                                            </svg>
                                            <span>{{ $post->likes_count }} likes</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-center py-4" style="color: #6B7280;">No posts yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Update tab buttons
            const tabs = ['foryou', 'following'];
            tabs.forEach(t => {
                const btn = document.getElementById(`tab-${t}`);
                const content = document.getElementById(`content-${t}`);
                const indicator = btn.querySelector('.tab-indicator');
                
                if (t === tab) {
                    btn.style.color = '#E0E0E0';
                    content.classList.remove('hidden');
                    if (!indicator) {
                        const newIndicator = document.createElement('div');
                        newIndicator.className = 'tab-indicator';
                        newIndicator.style.cssText = 'position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #8A2BE2; border-radius: 3px 3px 0 0;';
                        btn.appendChild(newIndicator);
                    }
                } else {
                    btn.style.color = '#6B7280';
                    content.classList.add('hidden');
                    if (indicator) {
                        indicator.remove();
                    }
                }
            });
        }

        // Navbar hide/show on scroll
        let lastScrollTop = 0;
        let scrollThreshold = 10;
        
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-tabs');
            if (!navbar) return;
            
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // If at top of page, always show navbar
            if (scrollTop <= 10) {
                navbar.style.transform = 'translateY(0)';
                navbar.style.opacity = '1';
                lastScrollTop = scrollTop;
                return;
            }
            
            // Check scroll direction
            if (scrollTop > lastScrollTop + 5 && scrollTop > scrollThreshold) {
                // Scrolling down - hide navbar
                navbar.style.transform = 'translateY(-100%)';
                navbar.style.opacity = '0';
            } else if (scrollTop < lastScrollTop - 5) {
                // Scrolling up - show navbar
                navbar.style.transform = 'translateY(0)';
                navbar.style.opacity = '1';
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);
    </script>

    <style>
        .tab-button:hover {
            background: rgba(138, 43, 226, 0.05);
        }
        
        .navbar-tabs {
            transform: translateY(0);
            opacity: 1;
        }
    </style>
</x-app-layout>
