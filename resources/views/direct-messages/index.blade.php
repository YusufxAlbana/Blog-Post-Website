<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Inbox') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="px-6">
            <h3 class="text-lg font-semibold mb-4" style="color: #E0E0E0;">Your Conversations</h3>
            <div class="space-y-3">
                    
                    @forelse($conversations as $conversation)
                        @php
                            $otherUser = $conversation->getOtherUser(auth()->id());
                            $unreadCount = $conversation->unreadCount(auth()->id());
                        @endphp
                        
                        <a href="{{ route('dm.show', $otherUser->id) }}" class="block p-4 rounded-lg transition-all" style="border: 1px solid rgba(138, 43, 226, 0.2); background: rgba(30, 30, 30, 0.95);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'; this.style.borderColor='rgba(138, 43, 226, 0.4)'" onmouseout="this.style.background='rgba(30, 30, 30, 0.95)'; this.style.borderColor='rgba(138, 43, 226, 0.2)'">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img 
                                        src="{{ $otherUser->avatar_url }}" 
                                        alt="{{ $otherUser->name }}"
                                        class="w-14 h-14 rounded-full object-cover"
                                        style="border: 2px solid rgba(138, 43, 226, 0.5);"
                                    >
                                    @if($unreadCount > 0)
                                        <span class="absolute -top-1 -right-1 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center" style="background: linear-gradient(135deg, #EF4444, #DC2626);">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-semibold" style="color: #E0E0E0;">{{ $otherUser->name }}</h4>
                                        @if($conversation->last_message_at)
                                            <span class="text-xs" style="color: #9CA3AF;">{{ $conversation->last_message_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($conversation->latestMessage)
                                        <p class="text-sm mt-1 {{ $unreadCount > 0 ? 'font-semibold' : '' }}" style="color: {{ $unreadCount > 0 ? '#E0E0E0' : '#9CA3AF' }};">
                                            {{ Str::limit($conversation->latestMessage->message, 60) }}
                                        </p>
                                    @else
                                        <p class="text-sm italic mt-1" style="color: #6B7280;">No messages yet</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium" style="color: #E0E0E0;">No conversations</h3>
                            <p class="mt-1 text-sm" style="color: #9CA3AF;">Start a conversation by visiting someone's profile</p>
                        </div>
                    @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
