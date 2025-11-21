<!-- Left Sidebar Navigation -->
<aside class="fixed left-0 top-0 bottom-0 w-64 z-50 hidden lg:block" style="background: rgba(26, 26, 26, 1); border-right: 1px solid rgba(138, 43, 226, 0.2);">
    <div class="flex flex-col h-full">
        <!-- Logo at Top -->
        <div class="px-6 py-6">
            <a href="{{ auth()->check() ? route('post.index') : route('welcome') }}" class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg flex items-center justify-center transition-all" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6)); mix-blend-mode: screen;">
                </div>
                <span class="text-xl font-bold tracking-wider transition-all" style="background: linear-gradient(135deg, #8A2BE2, #DA70D6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">BLOGMOUS</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 pb-4 space-y-2 overflow-y-auto">
            <a href="{{ route('post.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('post.index') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('post.index') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <span class="font-semibold">Blog</span>
            </a>

            @auth
                <a href="{{ route('dm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dm.*') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('dm.*') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="font-semibold">Messages</span>
                </a>

                <a href="{{ route('post.myPosts') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('post.myPosts') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('post.myPosts') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-semibold">My Posts</span>
                </a>

                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.messages.*') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('admin.messages.*') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-semibold">Admin Messages</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.users.*') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('admin.users.*') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-semibold">Users</span>
                    </a>
                @else
                    <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('messages.index') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('messages.index') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-semibold">Inbox</span>
                    </a>
                @endif

                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('reports.*') ? 'bg-purple' : '' }}" style="{{ request()->routeIs('reports.*') ? 'background: rgba(138, 43, 226, 0.2); color: #8A2BE2;' : 'color: #E0E0E0;' }}" onmouseover="if(!this.classList.contains('bg-purple')) this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="if(!this.classList.contains('bg-purple')) this.style.background=''">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    <span class="font-semibold">Feedback</span>
                </a>
            @endauth
        </nav>

        <!-- Create Post Button -->
        @auth
            <div class="px-4 pb-4">
                <a href="{{ route('post.create') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white; box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Create Post</span>
                </a>
            </div>
        @endauth

        <!-- Profile Section at Bottom -->
        <div class="p-4 border-t" style="border-color: rgba(138, 43, 226, 0.2);">
            @auth
                <a href="{{ route('profile.show', Auth::user()) }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all" style="color: #E0E0E0;" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                    <img 
                        src="{{ Auth::user()->avatar_url }}" 
                        alt="{{ Auth::user()->name }}"
                        class="w-10 h-10 rounded-full object-cover"
                        style="border: 2px solid rgba(138, 43, 226, 0.5); {{ Auth::user()->isAnonymous() ? 'padding: 4px; background: linear-gradient(135deg, #8A2BE2, #5A189A);' : '' }}"
                    >
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold truncate">{{ Auth::user()->name }}</div>
                        <div class="text-sm truncate" style="color: #9CA3AF;">View Profile</div>
                    </div>
                </a>
            @else
                <div class="space-y-2">
                    <a href="{{ route('login') }}" class="block text-center px-4 py-2 rounded-lg transition-all" style="color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">Log in</a>
                    <a href="{{ route('register') }}" class="block text-center px-4 py-2 rounded-lg transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;">Register</a>
                </div>
            @endauth
        </div>
    </div>
</aside>
