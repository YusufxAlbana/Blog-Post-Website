<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $user->name }}'s Profile
            </h2>
            @auth
                @if(auth()->id() === $user->id)
                    <button 
                        onclick="toggleEditMode()" 
                        id="edit-btn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                    >
                        Edit Profile
                    </button>
                    <button 
                        onclick="toggleEditMode()" 
                        id="cancel-btn"
                        class="hidden px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600"
                    >
                        Cancel
                    </button>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <!-- View Mode -->
                    <div id="view-mode">
                        <div class="flex items-start gap-6">
                            <img 
                                src="{{ $user->avatar_url }}" 
                                alt="{{ $user->name }}"
                                class="w-32 h-32 rounded-full object-cover border-4 border-gray-200"
                                id="profile-avatar"
                            >
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                                <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                                
                                @if($user->bio)
                                    <p class="mt-4 text-gray-700">{{ $user->bio }}</p>
                                @else
                                    <p class="mt-4 text-gray-400 italic">No bio yet</p>
                                @endif

                                <div class="mt-4 flex gap-4 text-sm text-gray-500">
                                    <span>{{ $user->posts()->where('is_published', true)->count() }} Posts</span>
                                    <span>Joined {{ $user->created_at->format('M Y') }}</span>
                                    @if($user->role === 'admin')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">Admin</span>
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
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                                            <div class="flex items-start gap-4">
                                                <div class="relative">
                                                    <img 
                                                        src="{{ $user->avatar_url }}" 
                                                        alt="{{ $user->name }}"
                                                        class="w-24 h-24 rounded-full object-cover border-4 border-gray-300 shadow-md"
                                                        id="avatar-preview"
                                                    >
                                                    @if($user->avatar)
                                                        <button 
                                                            type="button"
                                                            onclick="removeAvatar()"
                                                            class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-lg"
                                                            title="Remove avatar"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="flex-1">
                                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-blue-400 transition-colors cursor-pointer" id="drop-zone">
                                                        <input 
                                                            type="file" 
                                                            id="avatar" 
                                                            name="avatar" 
                                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                                            class="hidden"
                                                            onchange="previewAvatar(event)"
                                                        >
                                                        <label for="avatar" class="cursor-pointer block text-center">
                                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <p class="mt-2 text-sm text-gray-600">
                                                                <span class="font-semibold text-blue-600 hover:text-blue-500">Click to upload</span> or drag and drop
                                                            </p>
                                                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                                                </div>
                                            </div>
                                            @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                            <input 
                                                type="text" 
                                                id="name" 
                                                name="name" 
                                                value="{{ old('name', $user->name) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                required
                                            >
                                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Bio -->
                                        <div>
                                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                                            <textarea 
                                                id="bio" 
                                                name="bio" 
                                                rows="3"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Tell us about yourself..."
                                            >{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="email" 
                                                value="{{ old('email', $user->email) }}"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                required
                                            >
                                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Save Button -->
                                        <div class="flex gap-4">
                                            <button 
                                                type="submit" 
                                                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700"
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
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User's Posts -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Posts by {{ $user->name }}</h3>
                    
                    @forelse($posts as $post)
                        <div class="border-b pb-4 mb-4 last:border-b-0">
                            <h4 class="text-lg font-semibold">
                                <a href="{{ route('post.show', $post->slug) }}" class="text-gray-900 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h4>
                            <p class="text-sm text-gray-500 mt-1">{{ $post->created_at->diffForHumans() }}</p>
                            <p class="text-gray-700 mt-2">{{ Str::limit(strip_tags($post->body), 200) }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">No posts yet.</p>
                    @endforelse

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
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
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
