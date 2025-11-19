<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dm.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <img 
                src="{{ $otherUser->avatar_url }}" 
                alt="{{ $otherUser->name }}"
                class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
            >
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $otherUser->name }}
                </h2>
                <a href="{{ route('profile.show', $otherUser) }}" class="text-sm text-blue-600 hover:text-blue-800">
                    View Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Messages Container -->
                <div class="p-6 h-[500px] overflow-y-auto flex flex-col-reverse" id="messages-container">
                    <div class="space-y-4">
                        @forelse($messages as $message)
                            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="flex gap-2 max-w-[70%] {{ $message->sender_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                                    <img 
                                        src="{{ $message->sender->avatar_url }}" 
                                        alt="{{ $message->sender->name }}"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0"
                                    >
                                    <div>
                                        <div class="rounded-2xl {{ $message->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900' }} {{ $message->image ? '' : 'px-4 py-2' }}">
                                            @if($message->image)
                                                <a href="{{ $message->image_url }}" target="_blank" class="block">
                                                    <img 
                                                        src="{{ $message->image_url }}" 
                                                        alt="Image"
                                                        class="rounded-2xl max-w-full h-auto cursor-pointer hover:opacity-90 transition-opacity"
                                                        style="max-height: 400px; width: auto;"
                                                    >
                                                </a>
                                            @endif
                                            @if($message->message)
                                                <p class="break-words {{ $message->image ? 'px-4 py-2' : '' }}">{{ $message->message }}</p>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : '' }}">
                                            {{ $message->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="mt-2">No messages yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Message Input -->
                <div class="border-t p-4">
                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden mb-2 relative inline-block">
                        <img id="preview-img" src="" alt="Preview" class="max-h-32 rounded-lg border-2 border-blue-500">
                        <button 
                            type="button"
                            onclick="removeImage()"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="message-form" class="flex gap-2">
                        @csrf
                        <input type="file" id="image-input" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        
                        <button 
                            type="button"
                            onclick="document.getElementById('image-input').click()"
                            class="px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors"
                            title="Send image"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                        
                        <textarea 
                            id="message-input"
                            name="message" 
                            rows="1"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            placeholder="Type a message..."
                            onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }"
                        ></textarea>
                        <button 
                            type="button"
                            onclick="sendMessage()"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
const currentUserId = {{ auth()->id() }};
const otherUserId = {{ $otherUser->id }};
const currentUserAvatar = '{{ auth()->user()->avatar_url }}';

// Auto scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
}

// Add message to UI instantly
function addMessageToUI(message, isCurrentUser = true) {
    const messagesContainer = document.querySelector('#messages-container .space-y-4');
    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    const messageHTML = `
        <div class="flex ${isCurrentUser ? 'justify-end' : 'justify-start'}">
            <div class="flex gap-2 max-w-[70%] ${isCurrentUser ? 'flex-row-reverse' : ''}">
                <img 
                    src="${isCurrentUser ? currentUserAvatar : '{{ $otherUser->avatar_url }}'}" 
                    alt="Avatar"
                    class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0"
                >
                <div>
                    <div class="px-4 py-2 rounded-2xl ${isCurrentUser ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900'}">
                        <p class="break-words">${message}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ${isCurrentUser ? 'text-right' : ''}">
                        ${time}
                    </p>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

// Preview image before upload
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Check file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Image size must be less than 5MB');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Remove image preview
function removeImage() {
    document.getElementById('image-input').value = '';
    document.getElementById('image-preview').classList.add('hidden');
}

// Send message with optimistic update
function sendMessage() {
    const input = document.getElementById('message-input');
    const imageInput = document.getElementById('image-input');
    const message = input.value.trim();
    const hasImage = imageInput.files.length > 0;
    
    if (!message && !hasImage) return;
    
    // Create FormData for file upload
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    if (message) formData.append('message', message);
    if (hasImage) formData.append('image', imageInput.files[0]);
    
    // Add message to UI immediately (optimistic update)
    if (message || hasImage) {
        if (hasImage) {
            const reader = new FileReader();
            reader.onload = function(e) {
                addImageMessageToUI(e.target.result, message, true);
            }
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            addMessageToUI(message, true);
        }
    }
    
    // Clear inputs
    input.value = '';
    removeImage();
    input.focus();
    
    // Send to server in background
    fetch('{{ route('dm.store', $otherUser->id) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .catch(error => {
        console.error('Error sending message:', error);
    });
}

// Add image message to UI
function addImageMessageToUI(imageSrc, message, isCurrentUser = true) {
    const messagesContainer = document.querySelector('#messages-container .space-y-4');
    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    const messageHTML = `
        <div class="flex ${isCurrentUser ? 'justify-end' : 'justify-start'}">
            <div class="flex gap-2 max-w-[70%] ${isCurrentUser ? 'flex-row-reverse' : ''}">
                <img 
                    src="${isCurrentUser ? currentUserAvatar : '{{ $otherUser->avatar_url }}'}" 
                    alt="Avatar"
                    class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0"
                >
                <div>
                    <div class="rounded-2xl ${isCurrentUser ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900'}">
                        <img src="${imageSrc}" alt="Image" class="rounded-2xl max-w-full h-auto" style="max-height: 400px; width: auto;">
                        ${message ? `<p class="break-words px-4 py-2">${message}</p>` : ''}
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ${isCurrentUser ? 'text-right' : ''}">
                        ${time}
                    </p>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

// Auto scroll on load
window.addEventListener('load', scrollToBottom);
</script>
