<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Conversations</h3>
                    
                    @forelse($conversations as $conversation)
                        @php
                            $otherUser = $conversation->getOtherUser(auth()->id());
                            $unreadCount = $conversation->unreadCount(auth()->id());
                        @endphp
                        
                        <a href="{{ route('dm.show', $otherUser->id) }}" class="block hover:bg-gray-50 p-4 rounded-lg border-b transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img 
                                        src="{{ $otherUser->avatar_url }}" 
                                        alt="{{ $otherUser->name }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-gray-200"
                                    >
                                    @if($unreadCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-semibold text-gray-900">{{ $otherUser->name }}</h4>
                                        @if($conversation->last_message_at)
                                            <span class="text-xs text-gray-500">{{ $conversation->last_message_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($conversation->latestMessage)
                                        <p class="text-sm text-gray-600 mt-1 {{ $unreadCount > 0 ? 'font-semibold' : '' }}">
                                            {{ Str::limit($conversation->latestMessage->message, 60) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-400 italic mt-1">No messages yet</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No conversations</h3>
                            <p class="mt-1 text-sm text-gray-500">Start a conversation by visiting someone's profile</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
