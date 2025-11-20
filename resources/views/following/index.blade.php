<x-app-layout>
    <x-slot name="header">
        <div></div>
    </x-slot>
    
    <div class="py-0 min-h-screen" style="background-color: var(--bg-primary);">
        <div class="flex gap-6 px-6 pt-4">
            <!-- Main Content -->
            <div class="flex-1 max-w-2xl">
                <!-- Tabs Header -->
                <div class="sticky top-0 z-30" style="background: rgba(13, 13, 13, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
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

                <!-- For You Content -->
                <div id="content-foryou" class="tab-content">
                    <div class="space-y-4 py-4">
                        @forelse($allPosts as $post)
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
                        @forelse($posts as $post)
                            @include('partials.post-card', ['post' => $post])
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">You're not following anyone yet</h3>
                                <p class="mb-4" style="color: #9CA3AF;">Discover posts and follow users to see their content here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="w-80 flex-shrink-0 sticky top-0 h-screen overflow-y-auto py-4">
                <!-- Search Bar -->
                <div class="mb-4">
                    <form method="GET" action="{{ route('following.index') }}" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search"
                            class="w-full px-4 py-3 pl-12 rounded-full border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                            style="background: rgba(26, 26, 26, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                        >
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2" style="color: #6B7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <!-- What's happening -->
                <div class="rounded-2xl p-4" style="background: rgba(26, 26, 26, 0.8); border: 1px solid rgba(138, 43, 226, 0.2);">
                    <h3 class="text-xl font-bold mb-4" style="color: #E0E0E0;">What's happening</h3>
                    
                    <div class="space-y-4">
                        @php
                            $trending = [
                                ['category' => 'Technology', 'title' => 'AI Revolution', 'posts' => '15.2K'],
                                ['category' => 'Programming', 'title' => 'Laravel 11', 'posts' => '8.5K'],
                                ['category' => 'Design', 'title' => 'Dark Mode Trends', 'posts' => '12.3K'],
                                ['category' => 'Web Dev', 'title' => 'Tailwind CSS', 'posts' => '9.8K'],
                            ];
                        @endphp

                        @foreach($trending as $item)
                            <div class="py-3 cursor-pointer transition-all rounded-lg px-2" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-xs mb-1" style="color: #6B7280;">{{ $item['category'] }} · Trending</p>
                                        <p class="font-bold mb-1" style="color: #E0E0E0;">{{ $item['title'] }}</p>
                                        <p class="text-xs" style="color: #6B7280;">{{ $item['posts'] }} posts</p>
                                    </div>
                                    <button class="p-1 rounded-full transition-all" style="color: #6B7280;" onmouseover="this.style.background='rgba(138, 43, 226, 0.2)'; this.style.color='#E0E0E0'" onmouseout="this.style.background=''; this.style.color='#6B7280'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <button class="text-sm py-3 transition-colors" style="color: #8A2BE2;" onmouseover="this.style.color='#9D4EDD'" onmouseout="this.style.color='#8A2BE2'">
                            Show more
                        </button>
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
    </script>

    <style>
        .tab-button:hover {
            background: rgba(138, 43, 226, 0.05);
        }
        
        /* Hide scrollbar for right sidebar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(138, 43, 226, 0.3);
            border-radius: 3px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(138, 43, 226, 0.5);
        }
    </style>
</x-app-layout>
