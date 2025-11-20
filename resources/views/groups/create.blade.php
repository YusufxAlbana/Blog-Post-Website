<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Create New Group') }}
        </h2>
    </x-slot>

    <div class="py-6 min-h-screen" style="background-color: var(--bg-primary);">
        <div class="max-w-3xl mx-auto px-6">
            <div class="overflow-hidden shadow-sm rounded-2xl" style="background: #1A1A1A; border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <form method="POST" action="{{ route('groups.store') }}" id="create-group-form">
                        @csrf

                        <!-- Group Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Group Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                                style="background: rgba(50, 50, 50, 0.5); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                placeholder="Enter group name..."
                            >
                            @error('name')
                                <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Group Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Description (Optional)</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="3"
                                class="w-full px-4 py-3 rounded-xl border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                                style="background: rgba(50, 50, 50, 0.5); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                placeholder="What's this group about?"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Search Members -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Add Members</label>
                            <p class="text-sm mb-3" style="color: rgba(224, 224, 224, 0.6);">You can only add people who mutually follow you</p>
                            
                            <!-- Search Bar -->
                            <div class="relative mb-4">
                                <input 
                                    type="text" 
                                    id="member-search" 
                                    placeholder="Search mutual followers..."
                                    class="w-full px-4 py-3 pr-12 rounded-xl border-0 focus:ring-2 focus:ring-purple-500 transition-all"
                                    style="background: rgba(50, 50, 50, 0.5); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                >
                                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg class="w-5 h-5" style="color: rgba(138, 43, 226, 0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Available Members List -->
                            <div class="space-y-2 max-h-96 overflow-y-auto rounded-xl p-3" style="background: rgba(50, 50, 50, 0.3); border: 1px solid rgba(138, 43, 226, 0.2);" id="members-list">
                                @forelse($mutualFollowers as $user)
                                    <label class="flex items-center gap-3 p-3 rounded-lg cursor-pointer transition-all member-item" style="border: 1px solid rgba(138, 43, 226, 0.2);" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'" onmouseout="this.style.background=''">
                                        <input 
                                            type="checkbox" 
                                            name="members[]" 
                                            value="{{ $user->id }}"
                                            class="w-5 h-5 rounded transition-all"
                                            style="accent-color: #8A2BE2;"
                                        >
                                        <img 
                                            src="{{ $user->avatar_url }}" 
                                            alt="{{ $user->name }}"
                                            class="w-10 h-10 rounded-full object-cover"
                                            style="border: 2px solid rgba(138, 43, 226, 0.3);"
                                        >
                                        <div class="flex-1">
                                            <div class="font-semibold" style="color: #E0E0E0;">{{ $user->name }}</div>
                                            @if($user->bio)
                                                <div class="text-sm" style="color: rgba(224, 224, 224, 0.6);">{{ Str::limit($user->bio, 50) }}</div>
                                            @endif
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 mb-3" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p style="color: rgba(224, 224, 224, 0.6);">No mutual followers found</p>
                                        <p class="text-sm mt-2" style="color: rgba(224, 224, 224, 0.5);">Follow people and have them follow you back to add them to groups</p>
                                    </div>
                                @endforelse
                            </div>

                            <div id="no-results" class="hidden text-center py-8">
                                <p style="color: rgba(224, 224, 224, 0.6);">No members found matching your search</p>
                            </div>

                            @error('members')
                                <span class="text-sm mt-2 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Selected Members Count -->
                        <div class="mb-6 p-4 rounded-xl" style="background: rgba(138, 43, 226, 0.1); border: 1px solid rgba(138, 43, 226, 0.3);">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span style="color: #E0E0E0;">
                                    <span id="selected-count">0</span> member(s) selected (+ you as admin)
                                </span>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button 
                                type="submit" 
                                class="flex-1 px-6 py-3 text-white font-semibold rounded-xl transition-all"
                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'"
                                onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'"
                            >
                                Create Group
                            </button>
                            <a 
                                href="{{ route('dm.index') }}" 
                                class="px-6 py-3 font-semibold rounded-xl transition-all text-center"
                                style="background: rgba(138, 43, 226, 0.2); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                onmouseover="this.style.background='rgba(138, 43, 226, 0.3)'"
                                onmouseout="this.style.background='rgba(138, 43, 226, 0.2)'"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
// Search functionality
const searchInput = document.getElementById('member-search');
const membersList = document.getElementById('members-list');
const noResults = document.getElementById('no-results');
const memberItems = document.querySelectorAll('.member-item');

searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    let visibleCount = 0;

    memberItems.forEach(item => {
        const name = item.dataset.name;
        const email = item.dataset.email;
        
        if (name.includes(searchTerm) || email.includes(searchTerm)) {
            item.style.display = 'flex';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0 && searchTerm !== '') {
        membersList.style.display = 'none';
        noResults.classList.remove('hidden');
    } else {
        membersList.style.display = 'block';
        noResults.classList.add('hidden');
    }
});

// Update selected count
const checkboxes = document.querySelectorAll('input[name="members[]"]');
const selectedCount = document.getElementById('selected-count');

function updateCount() {
    const checked = document.querySelectorAll('input[name="members[]"]:checked').length;
    selectedCount.textContent = checked;
}

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateCount);
});
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
