<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Submit Feedback') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <p class="mb-6" style="color: #B0B0B0;">Found a bug or have a suggestion? Let us know! Your feedback will be sent to all administrators.</p>

                    <form method="POST" action="{{ route('reports.store') }}">
                        @csrf

                        <!-- Type -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">
                                Type <span style="color: #EF4444;">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center p-4 rounded-lg cursor-pointer transition-all" style="border: 2px solid rgba(138, 43, 226, 0.3); background: rgba(50, 50, 50, 0.3);" onclick="selectType(this, 'bug')">
                                    <input type="radio" name="type" value="bug" class="hidden" {{ old('type', 'bug') === 'bug' ? 'checked' : '' }} required>
                                    <div class="flex items-center gap-3">
                                        <div class="text-3xl">🐛</div>
                                        <div>
                                            <div class="font-semibold" style="color: #E0E0E0;">Bug Report</div>
                                            <div class="text-sm" style="color: #9CA3AF;">Report an issue</div>
                                        </div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 rounded-lg cursor-pointer transition-all" style="border: 2px solid rgba(138, 43, 226, 0.3); background: rgba(50, 50, 50, 0.3);" onclick="selectType(this, 'suggestion')">
                                    <input type="radio" name="type" value="suggestion" class="hidden" {{ old('type') === 'suggestion' ? 'checked' : '' }} required>
                                    <div class="flex items-center gap-3">
                                        <div class="text-3xl">💡</div>
                                        <div>
                                            <div class="font-semibold" style="color: #E0E0E0;">Suggestion</div>
                                            <div class="text-sm" style="color: #9CA3AF;">Share your ideas</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">
                                <span id="title-label">Title</span> <span style="color: #EF4444;">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                class="w-full px-4 py-2 rounded-lg transition-all"
                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                placeholder="e.g., Login button not working"
                                id="title-input"
                                required
                            >
                            @error('title')
                                <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">
                                <span id="description-label">Description</span> <span style="color: #EF4444;">*</span>
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="8"
                                class="w-full px-4 py-2 rounded-lg transition-all"
                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0; resize: vertical;"
                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                placeholder="Please describe in detail..."
                                id="description-textarea"
                                required
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-sm mt-1 block" style="color: #EF4444;">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4">
                            <button 
                                type="submit" 
                                class="px-6 py-2 text-white font-semibold rounded-lg transition-all"
                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'"
                            >
                                Submit Report
                            </button>
                            <a 
                                href="{{ route('reports.index') }}" 
                                class="px-6 py-2 font-semibold rounded-lg transition-all"
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

    <script>
        function selectType(element, type) {
            // Remove selected style from all options
            document.querySelectorAll('label[onclick^="selectType"]').forEach(label => {
                label.style.borderColor = 'rgba(138, 43, 226, 0.3)';
                label.style.background = 'rgba(50, 50, 50, 0.3)';
            });
            
            // Add selected style
            element.style.borderColor = 'rgba(138, 43, 226, 0.8)';
            element.style.background = 'rgba(138, 43, 226, 0.1)';
            
            // Update labels and placeholders based on type
            const titleInput = document.getElementById('title-input');
            const descriptionTextarea = document.getElementById('description-textarea');
            
            if (type === 'bug') {
                titleInput.placeholder = 'e.g., Login button not working';
                descriptionTextarea.placeholder = 'Please describe the bug in detail. Include steps to reproduce if possible...';
            } else {
                titleInput.placeholder = 'e.g., Add dark mode toggle';
                descriptionTextarea.placeholder = 'Please describe your suggestion in detail. What would you like to see improved or added?';
            }
        }
        
        // Set initial state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="type"]:checked');
            if (checkedRadio) {
                const label = checkedRadio.closest('label');
                selectType(label, checkedRadio.value);
            }
        });
    </script>
</x-app-layout>
