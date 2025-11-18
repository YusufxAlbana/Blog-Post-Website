<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Following') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex flex-col md:flex-row">
                            @if($post->featured_image)
                                <div class="md:w-1/3">
                                    <img 
                                        src="{{ $post->featured_image_url }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-64 md:h-full object-cover"
                                    >
                                </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex items-start gap-4">
                                    <a href="{{ route('profile.show', $post->user) }}">
                                        <img 
                                            src="{{ $post->user->avatar_url }}" 
                                            alt="{{ $post->user->name }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                                        >
                                    </a>
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold mb-2">
                                            <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span>By <a href="{{ route('profile.show', $post->user) }}" class="hover:text-blue-600">{{ $post->user->name }}</a></span>
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                                {{ $post->likesCount() }}
                                            </span>
                                        </div>
                                        <div class="text-gray-700 prose max-w-none">
                                            {{ Str::limit(strip_tags($post->body), 300) }}
                                        </div>
                                        <a href="{{ route('post.show', $post->slug) }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                                            Read more →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            <p class="mb-4">You're not following anyone yet.</p>
                            <a href="{{ route('post.index') }}" class="text-blue-600 hover:text-blue-800">
                                Discover posts and follow users!
                            </a>
                        </div>
                    </div>
                @endforelse

                @if($posts->hasPages())
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
