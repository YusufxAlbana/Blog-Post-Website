<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ auth()->id() === $user->id ? 'My Profile' : $user->name . "'s Profile" }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <!-- Profile Card -->
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-6" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    @if(auth()->id() === $user->id)
                        <!-- Edit Mode (Own Profile) -->
                        
                        <!-- Stats Section -->
                        <div class="mb-6 pb-6" style="border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex gap-6 text-sm" style="color: #9CA3AF;">
                                <span>{{ $user->posts()->where('is_published', true)->count() }} Posts</span>
                                <a href="{{ route('followers.list') }}" class="hover:underline transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#9CA3AF'">
                                    <span id="followers-count-{{ $user->id }}">{{ $user->followersCount() }} Followers</span>
                                </a>
                                <a href="{{ route('following.list') }}" class="hover:underline transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#9CA3AF'">
                                    {{ $user->followingCount() }} Following
                                </a>
                                <span>Joined {{ $user->created_at->format('F d, Y') }}</span>
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #C084FC;">Admin</span>
                                @endif
                            </div>
                        </div>
                        
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="space-y-6">
                                <!-- Avatar Upload -->
                                <div>
                                    <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Profile Picture</label>
                                    <div class="flex items-center gap-4">
                                        <div class="relative group">
                                            <img 
                                                src="{{ $user->avatar_url }}" 
                                                alt="{{ $user->name }}"
                                                class="w-32 h-32 rounded-full object-cover border-4 shadow-md"
                                                style="border-color: rgba(138, 43, 226, 0.3);"
                                                id="avatar-preview"
                                            >
                                            
                                            <!-- Camera Icon Button -->
                                            <label 
                                                for="avatar" 
                                                class="absolute bottom-0 right-0 p-2 rounded-full cursor-pointer shadow-lg transition-all"
                                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                                onmouseover="this.style.transform='scale(1.1)'"
                                                onmouseout="this.style.transform='scale(1)'"
                                                title="Change photo"
                                            >
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </label>
                                            
                                            <!-- Remove Button (if avatar exists) -->
                                            @if($user->avatar)
                                                <button 
                                                    type="button"
                                                    onclick="removeAvatar()"
                                                    class="absolute top-0 right-0 text-white rounded-full p-1.5 shadow-lg transition-all"
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
                                            
                                            <input 
                                                type="file" 
                                                id="avatar" 
                                                name="avatar" 
                                                accept="image/jpeg,image/png,image/jpg,image/gif"
                                                class="hidden"
                                                onchange="previewAvatar(event)"
                                            >
                                            <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                                        </div>
                                        
                                        <div class="flex-1">
                                            <p class="text-sm" style="color: #B0B0B0;">Click the camera icon to change your profile picture</p>
                                            <p class="text-xs mt-1" style="color: #6B7280;">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                    @error('avatar') <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span> @enderror
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
                        <div class="mt-8 pt-8" style="border-top: 1px solid rgba(138, 43, 226, 0.2);">
                            <button 
                                type="button"
                                onclick="togglePasswordForm()"
                                class="flex items-center justify-between w-full text-left transition-all"
                            >
                                <h3 class="text-lg font-semibold" style="color: #E0E0E0;">Change Password</h3>
                                <svg id="password-chevron" class="w-5 h-5 transition-transform" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div id="password-form" class="hidden mt-4">
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="space-y-4">
                                        <div>
                                            <label for="current_password" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Current Password</label>
                                            <input 
                                                type="password" 
                                                id="current_password" 
                                                name="current_password" 
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                            >
                                            @error('current_password') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="password" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">New Password</label>
                                            <input 
                                                type="password" 
                                                id="password" 
                                                name="password" 
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                            >
                                            @error('password') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Confirm Password</label>
                                            <input 
                                                type="password" 
                                                id="password_confirmation" 
                                                name="password_confirmation" 
                                                class="w-full px-4 py-2 rounded-lg transition-all"
                                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                            >
                                        </div>

                                        <button 
                                            type="submit" 
                                            class="px-6 py-2 text-white font-semibold rounded-lg transition-all"
                                            style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                            onmouseover="this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.transform='scale(1)'"
                                        >
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Logout Section -->
                        <div class="mt-8 pt-8" style="border-top: 1px solid rgba(138, 43, 226, 0.2);">
                            <h3 class="text-lg font-semibold mb-4" style="color: #EF4444;">Logout</h3>
                            <p class="mb-4" style="color: #9CA3AF;">Sign out from your account</p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="px-6 py-2 text-white font-semibold rounded-lg transition-all"
                                    style="background: linear-gradient(135deg, #DC2626, #991B1B);"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'"
                                    onclick="return confirm('Are you sure you want to logout?')"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- View Mode (Other User's Profile) -->
                        
                        <!-- Stats Section -->
                        <div class="mb-6 pb-6" style="border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
                            <div class="flex gap-6 text-sm" style="color: #9CA3AF;">
                                <span>{{ $user->posts()->where('is_published', true)->count() }} Posts</span>
                                <button type="button" onclick="showFollowersModal()" class="hover:underline transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#9CA3AF'">
                                    <span id="followers-count-{{ $user->id }}">{{ $user->followersCount() }} Followers</span>
                                </button>
                                <button type="button" onclick="showFollowingModal()" class="hover:underline transition-colors" style="color: #9CA3AF;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#9CA3AF'">
                                    {{ $user->followingCount() }} Following
                                </button>
                                <span>Joined {{ $user->created_at->format('F d, Y') }}</span>
                                @if($user->role === 'admin')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold" style="background: rgba(138, 43, 226, 0.2); color: #C084FC;">Admin</span>
                                @endif
                            </div>
                        </div>
                        
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
                    @endif

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

    <!-- Followers Modal -->
    <div id="followers-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0, 0, 0, 0.8);" onclick="closeFollowersModal()">
        <div class="max-w-md w-full mx-4 rounded-lg shadow-xl" style="background: rgba(30, 30, 30, 0.98); border: 1px solid rgba(138, 43, 226, 0.3);" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center p-4" style="border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
                <h3 class="text-lg font-semibold" style="color: #E0E0E0;">Followers</h3>
                <button onclick="closeFollowersModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 max-h-96 overflow-y-auto" id="followers-list">
                <p class="text-center" style="color: #9CA3AF;">Loading...</p>
            </div>
        </div>
    </div>

    <!-- Following Modal -->
    <div id="following-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0, 0, 0, 0.8);" onclick="closeFollowingModal()">
        <div class="max-w-md w-full mx-4 rounded-lg shadow-xl" style="background: rgba(30, 30, 30, 0.98); border: 1px solid rgba(138, 43, 226, 0.3);" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center p-4" style="border-bottom: 1px solid rgba(138, 43, 226, 0.2);">
                <h3 class="text-lg font-semibold" style="color: #E0E0E0;">Following</h3>
                <button onclick="closeFollowingModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 max-h-96 overflow-y-auto" id="following-list">
                <p class="text-center" style="color: #9CA3AF;">Loading...</p>
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

function togglePasswordForm() {
    const form = document.getElementById('password-form');
    const chevron = document.getElementById('password-chevron');
    
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        form.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

function showFollowersModal() {
    const modal = document.getElementById('followers-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Fetch followers
    fetch('/api/users/{{ $user->id }}/followers')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('followers-list');
            if (data.length === 0) {
                list.innerHTML = '<p class="text-center" style="color: #9CA3AF;">No followers yet</p>';
            } else {
                list.innerHTML = data.map(user => `
                    <a href="/profile/${user.id}" class="flex items-center gap-3 p-3 rounded-lg transition-all" style="border: 1px solid rgba(138, 43, 226, 0.2);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                        <img src="${user.avatar_url}" alt="${user.name}" class="w-12 h-12 rounded-full object-cover" style="border: 2px solid rgba(138, 43, 226, 0.3);">
                        <div class="flex-1">
                            <div class="font-semibold" style="color: #E0E0E0;">${user.name}</div>
                            ${user.bio ? `<div class="text-sm" style="color: #9CA3AF;">${user.bio.substring(0, 50)}${user.bio.length > 50 ? '...' : ''}</div>` : ''}
                        </div>
                    </a>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('followers-list').innerHTML = '<p class="text-center" style="color: #EF4444;">Failed to load followers</p>';
        });
}

function closeFollowersModal() {
    const modal = document.getElementById('followers-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function showFollowingModal() {
    const modal = document.getElementById('following-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Fetch following
    fetch('/api/users/{{ $user->id }}/following')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('following-list');
            if (data.length === 0) {
                list.innerHTML = '<p class="text-center" style="color: #9CA3AF;">Not following anyone yet</p>';
            } else {
                list.innerHTML = data.map(user => `
                    <a href="/profile/${user.id}" class="flex items-center gap-3 p-3 rounded-lg transition-all" style="border: 1px solid rgba(138, 43, 226, 0.2);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                        <img src="${user.avatar_url}" alt="${user.name}" class="w-12 h-12 rounded-full object-cover" style="border: 2px solid rgba(138, 43, 226, 0.3);">
                        <div class="flex-1">
                            <div class="font-semibold" style="color: #E0E0E0;">${user.name}</div>
                            ${user.bio ? `<div class="text-sm" style="color: #9CA3AF;">${user.bio.substring(0, 50)}${user.bio.length > 50 ? '...' : ''}</div>` : ''}
                        </div>
                    </a>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('following-list').innerHTML = '<p class="text-center" style="color: #EF4444;">Failed to load following</p>';
        });
}

function closeFollowingModal() {
    const modal = document.getElementById('following-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
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


</script>
