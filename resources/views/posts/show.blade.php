<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->title }}
            </h2>
            @auth
                @if(auth()->id() === $post->user_id || Auth::user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('post.edit', $post->slug) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                            Edit
                        </a>
                        <form action="{{ route('post.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($post->featured_image)
                    <img 
                        src="{{ $post->featured_image_url }}" 
                        alt="{{ $post->title }}"
                        class="w-full h-96 object-cover"
                    >
                @endif
                
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <a href="{{ route('profile.show', $post->user) }}">
                            <img 
                                src="{{ $post->user->avatar_url }}" 
                                alt="{{ $post->user->name }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                            >
                        </a>
                        <div>
                            <a href="{{ route('profile.show', $post->user) }}" class="font-semibold text-gray-900 hover:text-blue-600">
                                {{ $post->user->name }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $post->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none text-gray-800">
                        {!! nl2br(e($post->body)) !!}
                    </div>
                </div>
            </div>

            <!-- Chat Box Component -->
            @livewire('chat-box', ['post' => $post])
        </div>
    </div>
</x-app-layout>
