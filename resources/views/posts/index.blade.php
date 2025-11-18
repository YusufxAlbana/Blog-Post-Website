<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blog Posts') }}
            </h2>
            @auth
                <a href="{{ route('post.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Create New Post
                </a>
            @endauth
        </div>
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
                                        <div class="text-sm text-gray-500 mb-4">
                                            By <a href="{{ route('profile.show', $post->user) }}" class="hover:text-blue-600">{{ $post->user->name }}</a> • {{ $post->created_at->diffForHumans() }}
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
                            No posts yet. 
                            @auth
                                <a href="{{ route('post.create') }}" class="text-blue-600 hover:text-blue-800">Create the first one!</a>
                            @endauth
                        </div>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
