<nav x-data="{ open: false }" class="sticky top-0 z-50 shadow-lg" style="background: rgba(26, 26, 26, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('post.index') }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-lg flex items-center justify-center transition-all" style="background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-8 object-contain" style="filter: drop-shadow(0 2px 8px rgba(138, 43, 226, 0.6)); mix-blend-mode: screen;">
                        </div>
                        <span class="text-2xl font-bold tracking-wider transition-all" style="background: linear-gradient(135deg, #8A2BE2, #DA70D6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 0 30px rgba(138, 43, 226, 0.5);">BLOGMOUS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('post.index')" :active="request()->routeIs('post.index')">
                        {{ __('Blog') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dm.index')" :active="request()->routeIs('dm.*')">
                            {{ __('Inbox') }}
                        </x-nav-link>
                        <x-nav-link :href="route('following.index')" :active="request()->routeIs('following.index')">
                            {{ __('Following') }}
                        </x-nav-link>
                        <x-nav-link :href="route('post.myPosts')" :active="request()->routeIs('post.myPosts')">
                            {{ __('My Posts') }}
                        </x-nav-link>
                        @if(Auth::user()->isAdmin())
                            <x-nav-link :href="route('admin.messages.index')" :active="request()->routeIs('admin.messages.*')">
                                {{ __('Admin Messages') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                                {{ __('Users') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                                {{ __('Messages') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Profile Link -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <a href="{{ route('profile.show', Auth::user()) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg transition-all" style="color: #E0E0E0; background: rgba(138, 43, 226, 0.1);" onmouseover="this.style.background='rgba(138, 43, 226, 0.2)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.1)'">
                        <img 
                            src="{{ Auth::user()->avatar_url }}" 
                            alt="{{ Auth::user()->name }}"
                            class="w-8 h-8 rounded-full object-cover transition-all"
                            style="border: 2px solid rgba(138, 43, 226, 0.5); box-shadow: 0 0 15px rgba(138, 43, 226, 0.3);"
                        >
                        <div>{{ Auth::user()->name }}</div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm mr-4 px-4 py-2 rounded-lg transition-all" style="color: #E0E0E0;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#E0E0E0'">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm px-4 py-2 rounded-lg transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">Register</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('post.index')" :active="request()->routeIs('post.index')">
                {{ __('Blog') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
