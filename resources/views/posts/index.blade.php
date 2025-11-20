<x-app-layout>
    <div class="py-0 min-h-screen" style="background-color: var(--bg-primary);">
        <!-- Sticky Navbar with Tabs and Search -->
        <div class="sticky top-0 z-40" style="background: rgba(13, 13, 13, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
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
                <div class="w-80 flex-shrink-0 py-3 flex items-center gap-3">
                    <form method="GET" action="{{ route('post.index') }}" class="relative flex-1">
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
                    
                    <!-- Info Button -->
                    <button onclick="toggleInfoModal()" class="p-2 rounded-full transition-all" style="color: #8A2BE2; border: 2px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'; this.style.borderColor='#8A2BE2'" onmouseout="this.style.background=''; this.style.borderColor='rgba(138, 43, 226, 0.3)'" title="About BLOGMOUS">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
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
            <div class="w-80 flex-shrink-0">
                <div class="sticky top-20 py-4">
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
                                            <span>{{ $post->likes_count }} {{ $post->likes_count == 1 ? 'like' : 'likes' }}</span>
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
    </div>

    <!-- Info Modal -->
    <div id="infoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0, 0, 0, 0.8);" onclick="toggleInfoModal()">
        <div class="max-w-2xl w-full rounded-2xl p-8 max-h-[90vh] overflow-y-auto" style="background: rgba(26, 26, 26, 0.98); border: 2px solid rgba(138, 43, 226, 0.3);" onclick="event.stopPropagation()">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6));">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold" style="background: linear-gradient(135deg, #8A2BE2, #9D4EDD); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">BLOGMOUS</h2>
                        <p class="text-sm" style="color: #9CA3AF;">Version 1.0.0</p>
                    </div>
                </div>
                <button onclick="toggleInfoModal()" class="p-2 rounded-full transition-all" style="color: #6B7280;" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'; this.style.color='#E0E0E0'" onmouseout="this.style.background=''; this.style.color='#6B7280'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="space-y-6">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Tentang BLOGMOUS</h3>
                    <p style="color: #9CA3AF; line-height: 1.6;">
                        BLOGMOUS adalah platform blogging modern yang dirancang untuk memberikan pengalaman menulis dan berbagi yang aman, nyaman, dan menyenangkan. Dengan fokus pada privasi dan keamanan, BLOGMOUS memungkinkan Anda untuk mengekspresikan diri dengan bebas.
                    </p>
                </div>

                <!-- Features -->
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Fitur Utama</h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Rich Text Editor</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Tulis artikel dengan editor yang powerful dan mudah digunakan</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Multi-Image Upload</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Upload hingga 5 gambar per post dengan carousel interaktif</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Social Features</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Follow users, like posts, dan berinteraksi dengan komunitas</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Direct Messaging</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Kirim pesan pribadi ke user lain dengan real-time chat</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Anonymous Mode</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Posting secara anonim untuk privasi maksimal</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Advanced Search</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Cari posts berdasarkan judul, konten, atau nama user</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Why Built -->
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Mengapa BLOGMOUS Dibangun?</h3>
                    <p style="color: #9CA3AF; line-height: 1.6;">
                        BLOGMOUS dibangun dengan visi untuk menciptakan ruang digital yang aman dan nyaman bagi para penulis dan pembaca. Di era digital yang penuh dengan noise, kami percaya bahwa setiap orang berhak memiliki platform untuk berbagi pemikiran, cerita, dan pengalaman mereka tanpa khawatir tentang privasi dan keamanan.
                    </p>
                    <p class="mt-3" style="color: #9CA3AF; line-height: 1.6;">
                        Dengan desain modern dan fitur-fitur yang user-friendly, BLOGMOUS bertujuan untuk membuat blogging menjadi lebih accessible dan enjoyable untuk semua orang.
                    </p>
                </div>

                <!-- Tech Stack -->
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Technology Stack</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #8A2BE2;">Laravel 11</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #8A2BE2;">Tailwind CSS</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #8A2BE2;">Livewire</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #8A2BE2;">MySQL</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="pt-4 border-t" style="border-color: rgba(138, 43, 226, 0.2);">
                    <p class="text-center text-sm" style="color: #6B7280;">
                        © 2025 BLOGMOUS. Built with ❤️ for the community.
                    </p>
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

        function toggleInfoModal() {
            const modal = document.getElementById('infoModal');
            modal.classList.toggle('hidden');
        }
    </script>

    <style>
        .tab-button:hover {
            background: rgba(138, 43, 226, 0.05);
        }
    </style>
</x-app-layout>
