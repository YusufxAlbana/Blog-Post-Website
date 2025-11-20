<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                {{ $user->name }}'s Profile
            </h2>
            @auth
                @if(auth()->id() === $user->id)
                    <button 
                        onclick="toggleEditMode()" 
                        id="edit-btn"
                        class="p-2 text-white rounded-lg transition-all"
                        style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                        onmouseover="this.style.transform='scale(1.05)'"
                        onmouseout="this.style.transform='scale(1)'"
                        title="Edit Profile"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button 
                        onclick="toggleEditMode()" 
                        id="cancel-btn"
                        class="hidden p-2 text-white rounded-lg transition-all"
                        style="background: rgba(138, 43, 226, 0.2); color: #E0E0E0;"
                        title="Cancel"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <!-- Profile Card -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-6" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <!-- View Mode -->
                    <div id="view-mode">
                        <div class="flex items-start gap-6">
                            <img 
                                src="{{ $user->avatar_url }}" 
                                alt="{{ $user->name }}"
                                class="w-32 h-32 rounded-full object-cover border-4"
                                style="border-color: rgba(138, 43, 226, 0.3);"
                                id="profile-avatar"
                            >
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h1 class="text-3xl font-bold" style="color: #E0E0E0;">{{ $user->name }}</h1>
                                        <p class="mt-1" style="color: #9CA3AF;">{{ $user->email }}</p>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    @auth
                                        @if(auth()->id() !== $user->id)
                                            <div class="flex gap-2">
                                                <a 
                                                    href="{{ route('dm.show', $user->id) }}"
                                                    class="px-4 py-2 rounded-lg font-semibold transition-all flex items-center gap-2"
                                                    style="background: rgba(138, 43, 226, 0.2); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                                    onmouseover="this.style.background='rgba(138, 43, 226, 0.3)'"
                                                    onmouseout="this.style.background='rgba(138, 43, 226, 0.2)'"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    Message
                                                </a>
                                                <button 
                                                    onclick="toggleFollow({{ $user->id }})"
                                                    id="follow-btn-{{ $user->id }}"
                                                    class="px-4 py-2 rounded-lg font-semibold transition-all {{ auth()->user()->isFollowing($user->id) ? '' : '' }}"
                                                    style="{{ auth()->user()->isFollowing($user->id) ? 'background: rgba(138, 43, 226, 0.2); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);' : 'background: linear-gradient(135deg, #8A2BE2, #5A189A); color: white;' }}"
                                                >
                                                    <span id="follow-text-{{ $user->id }}">
                                                        {{ auth()->user()->isFollowing($user->id) ? 'Following' : 'Follow' }}
                                                    </span>
                                                </button>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                
                                @if($user->bio)
                                    <p class="mt-4" style="color: #B0B0B0;">{{ $user->bio }}</p>
                                @else
                                    <p class="mt-4 italic" style="color: #6B7280;">No bio yet</p>
                                @endif

                                <div class="mt-4 flex gap-4 text-sm" style="color: #9CA3AF;">
                                    <span>{{ $user->posts()->where('is_published', true)->count() }} Posts</span>
                                    <span id="followers-count-{{ $user->id }}">{{ $user->followersCount() }} Followers</span>
                                    <span>{{ $user->followingCount() }} Following</span>
                                    <span>Joined {{ $user->created_at->format('M Y') }}</span>
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #C084FC;">Admin</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    @auth
                        @if(auth()->id() === $user->id)
                            <div id="edit-mode" class="hidden">
                                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="space-y-6">
                                        <!-- Avatar Upload -->
                                        <div>
                                            <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Profile Picture</label>
                                            <div class="flex items-start gap-4">
                                                <div class="relative">
                                                    <img 
                                                        src="{{ $user->avatar_url }}" 
                                                        alt="{{ $user->name }}"
                                                        class="w-24 h-24 rounded-full object-cover border-4 shadow-md"
                                                        style="border-color: rgba(138, 43, 226, 0.3);"
                                                        id="avatar-preview"
                                                    >
                                                    @if($user->avatar)
                                                        <button 
                                                            type="button"
                                                            onclick="removeAvatar()"
                                                            class="absolute -top-1 -right-1 text-white rounded-full p-1 shadow-lg transition-all"
                                                            style="background: linear-gradient(135deg, #DC2626, #991B1B);"
                                                            onmouseover="this.style.transform='scale(1.1)'"
                                                            onmouseout="this.style.transform='scale(1)'"
                                                            title="Remove avatar"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <div class="border-2 border-dashed rounded-lg p-4 transition-colors cursor-pointer" style="border-color: rgba(138, 43, 226, 0.3); background: rgba(138, 43, 226, 0.05);" id="drop-zone">
                                                        <input 
                                                            type="file" 
                                                            id="avatar" 
                                                            name="avatar" 
                                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                                            class="hidden"
                                                            onchange="previewAvatar(event)"
                                                        >
                                                        <label for="avatar" class="cursor-pointer block text-center">
                                                            <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" style="color: #8A2BE2;">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <p class="mt-2 text-sm" style="color: #B0B0B0;">
                                                                <span class="font-semibold" style="color: #8A2BE2;">Click to upload</span> or drag and drop
                                                            </p>
                                                            <p class="mt-1 text-xs" style="color: #6B7280;">PNG, JPG, GIF up to 2MB</p>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                                                </div>
                                            </div>
                                            @error('avatar') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Name</label>
                                            <input 
                                                type="text" 
                                                id="name" 
                                                name="name" 
                                                value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                                required
                                            >
                                            @error('name') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div>
                                            <label for="bio" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Bio</label>
                                            <textarea 
                                                id="bio" 
                                                name="bio" 
                                                rows="3"
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                                placeholder="Tell us about yourself..."
                                            >{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Email</label>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="email" 
                                                value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                                required
                                            >
                                            @error('email') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Save Button -->
                                        <div class="flex gap-4">
                                            <button 
                                                type="submit" 
                                                class="px-6 py-2 text-white font-semibold rounded-lg transition-all"
                                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                                onmouseover="this.style.transform='scale(1.05)'"
                                                onmouseout="this.style.transform='scale(1)'"
                                            >
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Change Password Section -->
                                <div class="mt-8 pt-8 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4">Change Password</h3>
                                    <form method="post" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')

                                        <div class="space-y-4">
                                            <div>
                                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                                <input 
                                                    type="password" 
                                                    id="current_password" 
                                                    name="current_password" 
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                >
                                                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                                <input 
                                                    type="password" 
                                                    id="password" 
                                                    name="password" 
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                >
                                                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                                <input 
                                                    type="password" 
                                                    id="password_confirmation" 
                                                    name="password_confirmation" 
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                >
                                            </div>

                                            <button 
                                                type="submit" 
                                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700"
                                            >
                                                Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Logout Section -->
                                <div class="mt-8 pt-8 border-t border-gray-200">
                                    <h3 class="text-lg font-semibold mb-4 text-red-600">Logout</h3>
                                    <p class="text-gray-600 mb-4">Sign out from your account</p>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700"
                                            onclick="return confirm('Are you sure you want to logout?')"
                                        >
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User's Posts -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6" style="color: #E0E0E0;">Posts by {{ $user->name }}</h3>
                    
                    <div class="space-y-0">
                        @forelse($posts as $post)
                            <a href="{{ route('post.show', $post->slug) }}" class="block py-4 px-0 transition-all" style="border-bottom: 1px solid rgba(138, 43, 226, 0.2);" onmouseover="this.style.paddingLeft='12px'; this.style.background='rgba(138, 43, 226, 0.1)'; this.style.marginLeft='-12px'; this.style.marginRight='-12px'; this.style.paddingRight='12px';" onmouseout="this.style.paddingLeft='0'; this.style.background='transparent'; this.style.marginLeft='0'; this.style.marginRight='0'; this.style.paddingRight='0';">
                                <h4 class="text-lg font-semibold transition-colors" style="color: #E0E0E0;">
                                    {{ $post->title }}
                                </h4>
                                <p class="text-sm mt-1" style="color: #9CA3AF;">{{ $post->created_at->diffForHumans() }}</p>
                                <p class="mt-2" style="color: #B0B0B0;">{{ Str::limit(strip_tags($post->body), 200) }}</p>
                            </a>
                        @empty
                            <p style="color: #6B7280;">No posts yet.</p>
                        @endforelse
                    </div>

                    @if($posts->hasPages())
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


@if(session('status') === 'profile-updated')
    <script>
        alert('Profile updated successfully!');
    </script>
@endif

@if(session('status') === 'password-updated')
    <script>
        alert('Password updated successfully!');
    </script>
@endif

<script>
function toggleFollow(userId) {
    const btn = document.getElementById(`follow-btn-${userId}`);
    const text = document.getElementById(`follow-text-${userId}`);
    const count = document.getElementById(`followers-count-${userId}`);
    
    // Get current state by checking text content
    const isFollowing = text.textContent.trim() === 'Following';
    
    // Optimistic update
    if (isFollowing) {
        btn.style.background = 'linear-gradient(135deg, #8A2BE2, #5A189A)';
        btn.style.color = 'white';
        btn.style.border = 'none';
        text.textContent = 'Follow';
    } else {
        btn.style.background = 'rgba(138, 43, 226, 0.2)';
        btn.style.color = '#E0E0E0';
        btn.style.border = '1px solid rgba(138, 43, 226, 0.3)';
        text.textContent = 'Following';
    }
    
    // Send request
    fetch(`/users/${userId}/follow`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update followers count
        count.textContent = `${data.followers_count} Followers`;
        
        // Sync state
        if (data.following) {
            btn.style.background = 'rgba(138, 43, 226, 0.2)';
            btn.style.color = '#E0E0E0';
            btn.style.border = '1px solid rgba(138, 43, 226, 0.3)';
            text.textContent = 'Following';
        } else {
            btn.style.background = 'linear-gradient(135deg, #8A2BE2, #5A189A)';
            btn.style.color = 'white';
            btn.style.border = 'none';
            text.textContent = 'Follow';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert on error
        if (isFollowing) {
            btn.style.background = 'rgba(138, 43, 226, 0.2)';
            btn.style.color = '#E0E0E0';
            btn.style.border = '1px solid rgba(138, 43, 226, 0.3)';
            text.textContent = 'Following';
        } else {
            btn.style.background = 'linear-gradient(135deg, #8A2BE2, #5A189A)';
            btn.style.color = 'white';
            btn.style.border = 'none';
            text.textContent = 'Follow';
        }
    });
}

function toggleEditMode() {
    const viewMode = document.getElementById('view-mode');
    const editMode = document.getElementById('edit-mode');
    const editBtn = document.getElementById('edit-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    if (viewMode.classList.contains('hidden')) {
        viewMode.classList.remove('hidden');
        editMode.classList.add('hidden');
        editBtn.classList.remove('hidden');
        cancelBtn.classList.add('hidden');
    } else {
        viewMode.classList.add('hidden');
        editMode.classList.remove('hidden');
        editBtn.classList.add('hidden');
        cancelBtn.classList.remove('hidden');
    }
}

function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            event.target.value = '';
            return;
        }

        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please upload a valid image file (JPG, PNG, GIF)');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
            document.getElementById('profile-avatar').src = e.target.result;
        }
        reader.readAsDataURL(file);
        document.getElementById('remove_avatar').value = '0';
    }
}

function removeAvatar() {
    if (confirm('Are you sure you want to remove your profile picture?')) {
        document.getElementById('remove_avatar').value = '1';
        document.getElementById('avatar').value = '';
        const userName = '{{ $user->name }}';
        const defaultAvatar = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(userName) + '&size=200&background=random';
        document.getElementById('avatar-preview').src = defaultAvatar;
        document.getElementById('profile-avatar').src = defaultAvatar;
    }
}

// Drag and drop
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('avatar');

if (dropZone && fileInput) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.style.borderColor = 'rgba(138, 43, 226, 0.6)';
            dropZone.style.background = 'rgba(138, 43, 226, 0.1)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.style.borderColor = 'rgba(138, 43, 226, 0.3)';
            dropZone.style.background = 'rgba(138, 43, 226, 0.05)';
        }, false);
    });

    dropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            previewAvatar({ target: fileInput });
        }
    }, false);
}
</script>
