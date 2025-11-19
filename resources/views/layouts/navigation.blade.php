<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('post.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
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
                    <a href="{{ route('profile.show', Auth::user()) }}" class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 hover:bg-gray-50 transition ease-in-out duration-150">
                        <img 
                            src="{{ Auth::user()->avatar_url }}" 
                            alt="{{ Auth::user()->name }}"
                            class="w-8 h-8 rounded-full object-cover border border-gray-300"
                        >
                        <div>{{ Auth::user()->name }}</div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900 mr-4">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
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
