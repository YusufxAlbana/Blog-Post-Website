<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('dm.index') }}" class="transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#9CA3AF'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <img 
                src="{{ $otherUser->avatar_url }}" 
                alt="{{ $otherUser->name }}"
                class="w-10 h-10 rounded-full object-cover"
                style="border: 2px solid rgba(138, 43, 226, 0.5);"
            >
            <div>
                <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                    {{ $otherUser->name }}
                </h2>
                <a href="{{ route('profile.show', $otherUser) }}" class="text-sm transition-colors" style="color: #8A2BE2;" onmouseover="this.style.color='#9D4EDD'" onmouseout="this.style.color='#8A2BE2'">
                    View Profile
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-20 right-4 px-6 py-3 rounded-lg shadow-lg z-50" style="background: rgba(239, 68, 68, 0.95); color: white; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;">
        <p id="toast-message"></p>
    </div>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <!-- Messages Container -->
                <div class="p-6 h-[500px] overflow-y-auto flex flex-col-reverse" id="messages-container" style="background: rgba(20, 20, 20, 0.5);">
                    <div class="space-y-4">
                        @forelse($messages as $message)
                            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }} group" id="message-{{ $message->id }}">
                                <div class="flex gap-2 max-w-[70%] {{ $message->sender_id == auth()->id() ? 'flex-row-reverse' : '' }} relative">
                                    <img 
                                        src="{{ $message->sender->avatar_url }}" 
                                        alt="{{ $message->sender->name }}"
                                        class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                                        style="border: 1px solid rgba(138, 43, 226, 0.3);"
                                    >
                                    <div class="relative">
                                        <div class="rounded-2xl {{ $message->image ? '' : 'px-4 py-2' }}" style="{{ $message->sender_id == auth()->id() ? 'background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;' : 'background: rgba(50, 50, 50, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.2);' }}">
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
                                                <p class="break-words {{ $message->image ? 'px-4 py-2' : '' }}" id="msg-text-{{ $message->id }}">{{ $message->message }}</p>
                                            @endif
                                        </div>
                                        
                                        <!-- Edit/Delete Buttons (Only for own messages) -->
                                        @if($message->sender_id == auth()->id())
                                            <div class="absolute {{ $message->sender_id == auth()->id() ? '-left-20' : '-right-20' }} top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                                                @if($message->message)
                                                    <button 
                                                        onclick="editMessage({{ $message->id }}, '{{ addslashes($message->message ?? '') }}')"
                                                        class="p-1.5 rounded-full transition-all"
                                                        style="background: rgba(138, 43, 226, 0.2); color: #8A2BE2;"
                                                        onmouseover="this.style.background='rgba(138, 43, 226, 0.3)'"
                                                        onmouseout="this.style.background='rgba(138, 43, 226, 0.2)'"
                                                        title="Edit"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                                <button 
                                                    onclick="deleteMessage({{ $message->id }})"
                                                    class="p-1.5 rounded-full transition-all"
                                                    style="background: rgba(220, 38, 38, 0.2); color: #EF4444;"
                                                    onmouseover="this.style.background='rgba(220, 38, 38, 0.3)'"
                                                    onmouseout="this.style.background='rgba(220, 38, 38, 0.2)'"
                                                    title="Delete"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                        
                                        <p class="text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-right' : '' }}" style="color: #9CA3AF;">
                                            {{ $message->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="mt-2" style="color: #9CA3AF;">No messages yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Message Input -->
                <div class="p-4" style="border-top: 1px solid rgba(138, 43, 226, 0.2);">
                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden mb-2 relative inline-block">
                        <img id="preview-img" src="" alt="Preview" class="max-h-32 rounded-lg" style="border: 2px solid #8A2BE2;">
                        <button 
                            type="button"
                            onclick="removeImage()"
                            class="absolute -top-2 -right-2 text-white rounded-full p-1 transition-colors"
                            style="background: #EF4444;"
                            onmouseover="this.style.background='#DC2626'"
                            onmouseout="this.style.background='#EF4444'"
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
                            class="px-3 py-2 transition-colors"
                            style="color: #9CA3AF;"
                            onmouseover="this.style.color='#8A2BE2'"
                            onmouseout="this.style.color='#9CA3AF'"
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
                            class="flex-1 px-4 py-2 rounded-full focus:ring-2 focus:outline-none resize-none"
                            style="background: rgba(50, 50, 50, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                            placeholder="Type a message..."
                            onkeydown="if(event.key === 'Enter' && !event.shiftKey && !isSending) { event.preventDefault(); sendMessage(); }"
                        ></textarea>
                        <button 
                            type="button"
                            onclick="sendMessage()"
                            class="px-6 py-2 text-white font-semibold rounded-full transition-all"
                            style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'"
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
                    class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                    style="border: 1px solid rgba(138, 43, 226, 0.3);"
                >
                <div>
                    <div class="px-4 py-2 rounded-2xl" style="${isCurrentUser ? 'background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;' : 'background: rgba(50, 50, 50, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.2);'}">
                        <p class="break-words">${message}</p>
                    </div>
                    <p class="text-xs mt-1 ${isCurrentUser ? 'text-right' : ''}" style="color: #9CA3AF;">
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

// Prevent double submit
let isSending = false;

// Show toast notification
function showToast(message, type = 'error') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    toastMessage.textContent = message;
    
    // Set color based on type
    if (type === 'success') {
        toast.style.background = 'rgba(34, 197, 94, 0.95)';
    } else {
        toast.style.background = 'rgba(239, 68, 68, 0.95)';
    }
    
    // Show toast
    toast.style.opacity = '1';
    toast.style.visibility = 'visible';
    
    // Auto hide after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.visibility = 'hidden';
    }, 3000);
}

// Send message with optimistic update
function sendMessage() {
    // Prevent double submit
    if (isSending) return;
    
    const input = document.getElementById('message-input');
    const imageInput = document.getElementById('image-input');
    const message = input.value.trim();
    const hasImage = imageInput.files.length > 0;
    
    if (!message && !hasImage) return;
    
    // Set sending flag
    isSending = true;
    
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
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                // Only show toast for empty message error
                if (data.error && data.error.includes('required')) {
                    showToast(data.error);
                }
                throw new Error(data.error || 'Failed to send message');
            });
        }
        return response.json();
    })
    .then(data => {
        // Reset sending flag after successful send
        isSending = false;
    })
    .catch(error => {
        console.error('Error sending message:', error);
        // Don't show toast for successful sends, only for actual errors
        // Reset sending flag on error
        isSending = false;
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
                    class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                    style="border: 1px solid rgba(138, 43, 226, 0.3);"
                >
                <div>
                    <div class="rounded-2xl" style="${isCurrentUser ? 'background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;' : 'background: rgba(50, 50, 50, 0.8); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.2);'}">
                        <img src="${imageSrc}" alt="Image" class="rounded-2xl max-w-full h-auto" style="max-height: 400px; width: auto;">
                        ${message ? `<p class="break-words px-4 py-2">${message}</p>` : ''}
                    </div>
                    <p class="text-xs mt-1 ${isCurrentUser ? 'text-right' : ''}" style="color: #9CA3AF;">
                        ${time}
                    </p>
                </div>
            </div>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    scrollToBottom();
}

// Edit message
function editMessage(messageId, currentText) {
    const msgText = document.getElementById(`msg-text-${messageId}`);
    if (!msgText) return;
    
    const originalText = msgText.textContent;
    const newText = prompt('Edit message:', currentText);
    
    // Cancel if user clicked cancel
    if (newText === null) return;
    
    // If same text, no need to update
    if (newText === currentText) return;
    
    // Update UI immediately
    msgText.textContent = newText;
    
    // Send to server
    fetch(`/dm/messages/${messageId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: newText })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            msgText.textContent = originalText;
            alert('Failed to edit message');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        msgText.textContent = originalText;
        alert('Failed to edit message');
    });
}

// Delete message
function deleteMessage(messageId) {
    if (!confirm('Are you sure you want to delete this message?')) return;
    
    const messageElement = document.getElementById(`message-${messageId}`);
    if (!messageElement) return;
    
    // Remove from UI immediately
    messageElement.style.transition = 'all 0.3s ease';
    messageElement.style.opacity = '0';
    messageElement.style.transform = 'scale(0.8)';
    
    setTimeout(() => {
        messageElement.remove();
    }, 300);
    
    // Send to server
    fetch(`/dm/messages/${messageId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Auto scroll on load
window.addEventListener('load', scrollToBottom);
</script>
