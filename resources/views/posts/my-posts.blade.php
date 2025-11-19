<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Posts') }}
            </h2>
            <a href="{{ route('post.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex flex-col md:flex-row">
                            @if($post->featured_image)
                                <div class="md:w-1/4">
                                    <img 
                                        src="{{ $post->featured_image_url }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-48 md:h-full object-cover"
                                    >
                                </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold mb-2">
                                            <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $post->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </div>
                                        <div class="text-gray-700 prose max-w-none">
                                            {{ Str::limit(strip_tags($post->body), 200) }}
                                        </div>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <a href="{{ route('post.edit', $post->slug) }}" class="p-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700" title="Edit Post">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('post.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700" title="Delete Post">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            You haven't created any posts yet. 
                            <a href="{{ route('post.create') }}" class="text-blue-600 hover:text-blue-800">Create your first post!</a>
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
