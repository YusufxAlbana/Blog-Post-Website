<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold mb-4">Chat & Comments</h3>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Messages List -->
    <div class="mb-6 space-y-4 max-h-96 overflow-y-auto" id="messages-container">
        @forelse($messages as $msg)
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-semibold text-gray-800">{{ $msg->name ?? 'Anonymous' }}</span>
                    <span class="text-sm text-gray-500">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700">{{ $msg->message }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No messages yet. Be the first to comment!</p>
        @endforelse
    </div>

    <!-- Message Form -->
    <form wire:submit.prevent="send" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name (optional)</label>
                <input 
                    type="text" 
                    id="name" 
                    wire:model="name" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Your name"
                >
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (optional)</label>
                <input 
                    type="email" 
                    id="email" 
                    wire:model="email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="your@email.com"
                >
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
            <textarea 
                id="message" 
                wire:model="message" 
                rows="4" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Write your message here..."
            ></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button 
            type="submit" 
            class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200"
        >
            Send Message
        </button>
    </form>
</div>

@script
<script>
    Echo.channel('post.{{ $post->id }}')
        .listen('MessagePosted', (e) => {
            // Reload component to show new message
            $wire.$refresh();
        });
</script>
@endscript
