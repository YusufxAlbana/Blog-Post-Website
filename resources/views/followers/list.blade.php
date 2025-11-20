<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Followers List') }}
        </h2>
    </x-slot>

    <div class="py-6 min-h-screen" style="background-color: var(--bg-primary);">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Search Bar -->
            <div class="mb-6">
                <form method="GET" action="{{ route('followers.list') }}" class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search ?? '' }}"
                        placeholder="Search followers..."
                        class="w-full px-4 py-3 pr-12 rounded-xl border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                        style="background: #1A1A1A; color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                    >
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 rounded-lg transition-all" style="color: #8A2BE2;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Followers List -->
            <div class="space-y-3 fade-in">
                @forelse($followers as $user)
                    <a href="{{ route('profile.show', $user) }}" class="block overflow-hidden rounded-2xl transition-all" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(138, 43, 226, 0.2)'; this.style.borderColor='#8A2BE2'" onmouseout="this.style.transform=''; this.style.boxShadow=''; this.style.borderColor='rgba(138, 43, 226, 0.2)'">
                        <div class="p-4">
                            <div class="flex items-center gap-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <img 
                                        src="{{ $user->avatar_url }}" 
                                        alt="{{ $user->name }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-gray-200 transition-colors"
                                        style="border-color: rgba(138, 43, 226, 0.3);"
                                    >
                                </div>
                                
                                <!-- User Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-lg" style="color: var(--text-primary);">
                                        {{ $user->name }}
                                    </h3>
                                    @if($user->bio)
                                        <p class="text-sm mt-1" style="color: rgba(224, 224, 224, 0.7);">
                                            {{ Str::limit($user->bio, 100) }}
                                        </p>
                                    @else
                                        <p class="text-sm mt-1 italic" style="color: rgba(224, 224, 224, 0.5);">
                                            No bio yet
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Arrow Icon -->
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 transition-transform" style="color: rgba(138, 43, 226, 0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">
                                @if($search)
                                    No followers found matching "{{ $search }}"
                                @else
                                    You don't have any followers yet
                                @endif
                            </h3>
                            <p class="mb-4" style="color: #9CA3AF;">
                                @if($search)
                                    Try a different search term
                                @else
                                    Share your posts to gain followers
                                @endif
                            </p>
                            @if(!$search)
                                <a href="{{ route('post.create') }}" class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                                    Create a Post
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse

                @if($followers->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $followers->appends(['search' => $search])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<style>
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
