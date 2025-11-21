<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="max-w-4xl mx-auto px-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Images Upload (1-10 images, optional) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Images (Optional, Max 10)</label>
                            <div class="border-2 border-dashed rounded-lg p-6 transition-all cursor-pointer" style="border-color: rgba(138, 43, 226, 0.3); background: rgba(40, 40, 40, 0.5);" onmouseover="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.background='rgba(138, 43, 226, 0.05)'" onmouseout="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.background='rgba(40, 40, 40, 0.5)'">
                                <input 
                                    type="file" 
                                    id="images" 
                                    name="images[]" 
                                    accept="image/*"
                                    multiple
                                    class="hidden"
                                    onchange="previewMultipleImages(event)"
                                >
                                <label for="images" class="cursor-pointer block text-center">
                                    <svg class="mx-auto h-12 w-12" style="color: #8A2BE2;" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm" style="color: #B0B0B0;">
                                        <span class="font-semibold transition-colors" style="color: #8A2BE2;" onmouseover="this.style.color='#9D4EDD'" onmouseout="this.style.color='#8A2BE2'">Click to upload images</span> or drag and drop
                                    </p>
                                    <p class="mt-1 text-xs" style="color: #6B7280;">Select 1-10 images • PNG, JPG, GIF, WebP • 5MB each</p>
                                </label>
                            </div>
                            <!-- Images Preview Grid -->
                            <div id="images-preview-grid" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-2 hidden"></div>
                            @error('images.*') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Title (Max 100 characters)</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}"
                                class="w-full px-4 py-2 rounded-lg transition-all"
                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                required
                            >
                            @error('title') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="body" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Content</label>
                            <textarea 
                                id="body" 
                                name="body" 
                                rows="15"
                                class="w-full px-4 py-2 rounded-lg transition-all"
                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0; resize: vertical;"
                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                required
                            >{{ old('body') }}</textarea>
                            @error('body') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="is_published" 
                                    value="1" 
                                    {{ old('is_published', true) ? 'checked' : '' }}
                                    class="rounded shadow-sm"
                                    style="border-color: rgba(138, 43, 226, 0.5); color: #8A2BE2;"
                                >
                                <span class="ml-2 text-sm" style="color: #E0E0E0;">Publish immediately</span>
                            </label>
                        </div>

                        <div class="flex gap-4">
                            <button 
                                type="submit" 
                                class="px-6 py-2 text-white font-semibold rounded-lg transition-all"
                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(138, 43, 226, 0.4)'"
                                onmouseout="this.style.transform=''; this.style.boxShadow=''"
                            >
                                Create Post
                            </button>
                            <a 
                                href="{{ route('post.index') }}" 
                                class="px-6 py-2 font-semibold rounded-lg transition-all"
                                style="background: rgba(138, 43, 226, 0.1); color: #E0E0E0; border: 1px solid rgba(138, 43, 226, 0.3);"
                                onmouseover="this.style.background='rgba(138, 43, 226, 0.2)'"
                                onmouseout="this.style.background='rgba(138, 43, 226, 0.1)'"
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
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
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
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Drag and drop
const dropZone = document.getElementById('drop-zone-create');
const fileInput = document.getElementById('featured_image');

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
        previewImage({ target: fileInput });
    }
}, false);

// Preview multiple images
function previewMultipleImages(event) {
    const files = Array.from(event.target.files).slice(0, 10); // Max 10 images
    const grid = document.getElementById('images-preview-grid');
    grid.innerHTML = '';
    
    if (files.length > 0) {
        grid.classList.remove('hidden');
        
        files.forEach((file, index) => {
            if (file.size > 5 * 1024 * 1024) {
                alert(`Image ${index + 1} is too large. Max 5MB per image.`);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" 
                         class="w-full h-32 object-cover rounded-lg border-2 transition-all"
                         style="border-color: rgba(138, 43, 226, 0.3);"
                         onmouseover="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.transform='scale(1.05)'"
                         onmouseout="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.transform='scale(1)'"
                         alt="Preview ${index + 1}">
                    <div class="absolute top-1 right-1 text-white text-xs px-2 py-1 rounded" style="background: rgba(138, 43, 226, 0.8);">
                        ${index + 1}
                    </div>
                `;
                grid.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
