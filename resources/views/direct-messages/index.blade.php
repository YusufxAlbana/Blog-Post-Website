<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                {{ __('Inbox') }}
            </h2>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('groups.create') }}" 
                    class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all"
                    style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'"
                    onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Group
            </a>
            <x-info-button id="Inbox" title="About Inbox" modal-title="Inbox" subtitle="Direct Messaging">
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Direct Messaging</h3>
                    <p style="color: #9CA3AF; line-height: 1.6;">
                        Inbox adalah tempat untuk berkomunikasi secara pribadi dengan user lain. Anda dapat mengirim pesan teks, berbagi pemikiran, atau berdiskusi secara private.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Fitur Inbox</h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Private Chat</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Kirim pesan pribadi ke user lain secara one-on-one</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Group Chat</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Buat grup untuk diskusi dengan banyak user sekaligus</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Edit & Delete</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Edit atau hapus pesan yang sudah dikirim</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-info-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="px-6">
            <!-- Tabs -->
            <div class="flex gap-4 mb-6 border-b" style="border-color: rgba(138, 43, 226, 0.2);">
                <button 
                    onclick="switchTab('direct')" 
                    id="tab-direct"
                    class="px-4 py-3 font-semibold transition-all tab-button active"
                    style="color: #8A2BE2; border-bottom: 2px solid #8A2BE2;"
                >
                    Direct Messages
                </button>
                <button 
                    onclick="switchTab('groups')" 
                    id="tab-groups"
                    class="px-4 py-3 font-semibold transition-all tab-button"
                    style="color: rgba(224, 224, 224, 0.6); border-bottom: 2px solid transparent;"
                >
                    Groups
                </button>
            </div>

            <!-- Direct Messages Tab -->
            <div id="content-direct" class="tab-content">
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

            <!-- Groups Tab -->
            <div id="content-groups" class="tab-content hidden">
                <div class="space-y-3">
                    @php
                        $groups = auth()->user()->groups()->with(['latestMessage.user', 'members'])->latest('updated_at')->get();
                    @endphp
                    
                    @forelse($groups as $group)
                        <a href="{{ route('groups.show', $group) }}" class="block p-4 rounded-lg transition-all" style="border: 1px solid rgba(138, 43, 226, 0.2); background: rgba(30, 30, 30, 0.95);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'; this.style.borderColor='rgba(138, 43, 226, 0.4)'" onmouseout="this.style.background='rgba(30, 30, 30, 0.95)'; this.style.borderColor='rgba(138, 43, 226, 0.2)'">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img 
                                        src="{{ $group->avatar_url }}" 
                                        alt="{{ $group->name }}"
                                        class="w-14 h-14 rounded-full object-cover"
                                        style="border: 2px solid rgba(138, 43, 226, 0.5);"
                                    >
                                    <span class="absolute -bottom-1 -right-1 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center" style="background: linear-gradient(135deg, #8A2BE2, #5A189A);">
                                        {{ $group->members()->count() }}
                                    </span>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-semibold" style="color: #E0E0E0;">{{ $group->name }}</h4>
                                        @if($group->latestMessage)
                                            <span class="text-xs" style="color: #9CA3AF;">{{ $group->latestMessage->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($group->latestMessage)
                                        <p class="text-sm mt-1" style="color: #9CA3AF;">
                                            <span class="font-semibold" style="color: #8A2BE2;">{{ $group->latestMessage->user->name }}:</span>
                                            {{ Str::limit($group->latestMessage->message, 50) }}
                                        </p>
                                    @else
                                        <p class="text-sm italic mt-1" style="color: #6B7280;">No messages yet</p>
                                    @endif
                                    
                                    <p class="text-xs mt-1" style="color: rgba(224, 224, 224, 0.5);">
                                        {{ $group->members()->count() }} members
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium" style="color: #E0E0E0;">No groups yet</h3>
                            <p class="mt-1 text-sm" style="color: #9CA3AF;">Create a group to chat with multiple people</p>
                            <a 
                                href="{{ route('groups.create') }}" 
                                class="inline-flex items-center px-4 py-2 mt-4 text-white rounded-xl font-semibold transition-all"
                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'"
                                onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Group
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function switchTab(tab) {
    // Update tab buttons
    const tabs = document.querySelectorAll('.tab-button');
    tabs.forEach(t => {
        t.style.color = 'rgba(224, 224, 224, 0.6)';
        t.style.borderBottom = '2px solid transparent';
    });
    
    const activeTab = document.getElementById(`tab-${tab}`);
    activeTab.style.color = '#8A2BE2';
    activeTab.style.borderBottom = '2px solid #8A2BE2';
    
    // Update content
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(c => c.classList.add('hidden'));
    
    document.getElementById(`content-${tab}`).classList.remove('hidden');
}
</script>

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
