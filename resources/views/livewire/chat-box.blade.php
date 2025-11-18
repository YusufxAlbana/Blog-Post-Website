<div class="mt-8 bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold mb-4">Chat & Comments</h3>

    <!-- Messages List -->
    <div class="mb-6 space-y-4 max-h-96 overflow-y-auto" id="messages-container">
        @forelse($messages as $msg)
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="flex gap-3 mb-2">
                    <!-- Avatar -->
                    @if($msg->user)
                        <a href="{{ route('profile.show', $msg->user) }}">
                            <img 
                                src="{{ $msg->user->avatar_url }}" 
                                alt="{{ $msg->user->name }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                            >
                        </a>
                    @else
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">
                            {{ substr($msg->name ?? 'A', 0, 1) }}
                        </div>
                    @endif
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                @if($msg->user)
                                    <a href="{{ route('profile.show', $msg->user) }}" class="font-semibold text-gray-800 hover:text-blue-600">
                                        {{ $msg->user->name }}
                                    </a>
                                @else
                                    <span class="font-semibold text-gray-800">{{ $msg->name ?? 'Anonymous' }}</span>
                                @endif
                                <span class="text-sm text-gray-500 ml-2">{{ $msg->created_at->diffForHumans() }}</span>
                                @if($msg->created_at != $msg->updated_at)
                                    <span class="text-xs text-gray-400 ml-1">(edited)</span>
                                @endif
                            </div>
                    
                            <div class="flex items-center gap-1">
                                <!-- Like Button -->
                                @auth
                                    <button 
                                        onclick="toggleMessageLike({{ $msg->id }})"
                                        id="message-like-btn-{{ $msg->id }}"
                                        class="flex items-center gap-1 px-2 py-1 rounded transition-colors text-sm {{ $msg->isLikedBy(auth()->user()) ? 'text-red-600' : 'text-gray-500 hover:text-red-600' }}"
                                    >
                                        <svg class="w-4 h-4 {{ $msg->isLikedBy(auth()->user()) ? 'fill-current' : '' }}" fill="{{ $msg->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <span id="message-likes-count-{{ $msg->id }}">{{ $msg->likesCount() }}</span>
                                    </button>
                                    
                                    <!-- Edit & Delete Buttons (only for own messages) -->
                                    @if($msg->user_id === auth()->id())
                                        <button 
                                            onclick="editMessage({{ $msg->id }}, '{{ addslashes($msg->message) }}')"
                                            class="text-gray-500 hover:text-blue-600 p-1"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        <button 
                                            onclick="deleteMessage({{ $msg->id }})"
                                            class="text-gray-500 hover:text-red-600 p-1"
                                            title="Delete"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                @else
                                    <div class="flex items-center gap-1 text-gray-500 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <span>{{ $msg->likesCount() }}</span>
                                    </div>
                                @endauth
                            </div>
                        </div>
                        <p class="text-gray-700 mt-2" id="message-text-{{ $msg->id }}">{{ $msg->message }}</p>
                        
                        <!-- Edit Form (hidden by default) -->
                        <div id="edit-form-{{ $msg->id }}" class="hidden mt-2">
                            <textarea 
                                id="edit-textarea-{{ $msg->id }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                rows="3"
                            ></textarea>
                            <div class="flex gap-2 mt-2">
                                <button 
                                    onclick="saveEdit({{ $msg->id }})"
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700"
                                >
                                    Save
                                </button>
                                <button 
                                    onclick="cancelEdit({{ $msg->id }})"
                                    class="px-3 py-1 bg-gray-300 text-gray-700 text-sm rounded hover:bg-gray-400"
                                >
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No messages yet. Be the first to comment!</p>
        @endforelse
    </div>

    <!-- Message Form -->
    <form wire:submit.prevent="send" class="space-y-4">
        @guest
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
        @endguest

        <div>
            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
            <textarea 
                id="message-textarea" 
                wire:model.defer="message" 
                rows="4" 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Write your message here..."
            ></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button 
            type="submit" 
            class="w-full md:w-auto px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Send Message</span>
            <span wire:loading>
                <svg class="inline w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            </span>
        </button>
    </form>
</div>

@script
<script>
    // Listen for message-sent event to clear textarea
    $wire.on('message-sent', () => {
        document.getElementById('message-textarea').value = '';
    });

    // Edit message
    window.editMessage = function(messageId, currentText) {
        const textEl = document.getElementById(`message-text-${messageId}`);
        const formEl = document.getElementById(`edit-form-${messageId}`);
        const textarea = document.getElementById(`edit-textarea-${messageId}`);
        
        textEl.classList.add('hidden');
        formEl.classList.remove('hidden');
        textarea.value = currentText;
        textarea.focus();
    };

    // Cancel edit
    window.cancelEdit = function(messageId) {
        const textEl = document.getElementById(`message-text-${messageId}`);
        const formEl = document.getElementById(`edit-form-${messageId}`);
        
        textEl.classList.remove('hidden');
        formEl.classList.add('hidden');
    };

    // Save edit
    window.saveEdit = function(messageId) {
        const textarea = document.getElementById(`edit-textarea-${messageId}`);
        const newText = textarea.value.trim();
        
        if (!newText) {
            alert('Message cannot be empty');
            return;
        }
        
        fetch(`/messages/${messageId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: newText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const textEl = document.getElementById(`message-text-${messageId}`);
                const formEl = document.getElementById(`edit-form-${messageId}`);
                
                textEl.textContent = data.message;
                textEl.classList.remove('hidden');
                formEl.classList.add('hidden');
                
                // Refresh to show (edited) label
                $wire.$refresh();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update message');
        });
    };

    // Delete message
    window.deleteMessage = function(messageId) {
        if (!confirm('Are you sure you want to delete this message?')) {
            return;
        }
        
        fetch(`/messages/${messageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh component to remove message
                $wire.$refresh();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete message');
        });
    };

    window.toggleMessageLike = function(messageId) {
        const btn = document.getElementById(`message-like-btn-${messageId}`);
        const count = document.getElementById(`message-likes-count-${messageId}`);
        const svg = btn.querySelector('svg');
        
        // Get current state
        const isLiked = btn.classList.contains('text-red-600');
        const currentCount = parseInt(count.textContent);
        
        // OPTIMISTIC UPDATE - Update UI immediately
        svg.style.transition = 'transform 0.2s ease-in-out';
        svg.style.transform = 'scale(1.3)';
        
        if (isLiked) {
            // Unlike
            btn.classList.remove('text-red-600');
            btn.classList.add('text-gray-500', 'hover:text-red-600');
            svg.setAttribute('fill', 'none');
            svg.classList.remove('fill-current');
            count.textContent = currentCount - 1;
        } else {
            // Like
            btn.classList.remove('text-gray-500', 'hover:text-red-600');
            btn.classList.add('text-red-600');
            svg.setAttribute('fill', 'currentColor');
            svg.classList.add('fill-current');
            count.textContent = currentCount + 1;
        }
        
        // Reset scale
        setTimeout(() => svg.style.transform = 'scale(1)', 200);
        
        // Send request in background (no waiting)
        fetch(`/messages/${messageId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            // Sync with server response
            count.textContent = data.likes_count;
        })
        .catch(error => {
            // Revert on error
            console.error('Error:', error);
            if (isLiked) {
                btn.classList.add('text-red-600');
                btn.classList.remove('text-gray-500', 'hover:text-red-600');
                svg.setAttribute('fill', 'currentColor');
                svg.classList.add('fill-current');
                count.textContent = currentCount;
            } else {
                btn.classList.remove('text-red-600');
                btn.classList.add('text-gray-500', 'hover:text-red-600');
                svg.setAttribute('fill', 'none');
                svg.classList.remove('fill-current');
                count.textContent = currentCount;
            }
        });
    }
</script>
@endscript
