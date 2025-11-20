<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <div class="space-y-4">
                    @if($messages->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">No messages yet</h3>
                            <p style="color: #9CA3AF;">No approved messages to display</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($messages as $message)
                                <a href="{{ route('post.show', $message->post->slug) }}" class="block pb-4 p-4 rounded-lg transition-all cursor-pointer" style="border: 1px solid rgba(138, 43, 226, 0.2); background: rgba(40, 40, 40, 0.5); text-decoration: none;" onmouseover="this.style.borderColor='rgba(138, 43, 226, 0.4)'; this.style.background='rgba(40, 40, 40, 0.7)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='rgba(138, 43, 226, 0.2)'; this.style.background='rgba(40, 40, 40, 0.5)'; this.style.transform=''">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg" style="color: #E0E0E0;">{{ $message->name }}</h3>
                                            <p class="text-sm" style="color: #9CA3AF;">{{ $message->email }}</p>
                                            <p class="text-sm flex items-center gap-1" style="color: #8A2BE2;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Post: {{ $message->post->title }}
                                            </p>
                                        </div>
                                        <span class="text-xs" style="color: #9CA3AF;">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-2" style="color: rgba(224, 224, 224, 0.8);">{{ $message->message }}</p>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-center">
                            {{ $messages->links() }}
                        </div>
                    @endif
            </div>
        </div>
    </div>
</x-app-layout>
