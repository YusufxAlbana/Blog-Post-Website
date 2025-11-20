<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                <div class="p-6">
                    <form action="{{ route('post.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Images Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Images (Optional, Max 10)</label>
                            
                            @if($post->images && $post->images->count() > 0)
                                <div class="mb-4">
                                    <p class="text-sm mb-2" style="color: #9CA3AF;">Current Images:</p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3" id="current-images-grid">
                                        @foreach($post->images as $index => $image)
                                            <div class="relative group rounded-lg overflow-hidden" id="image-{{ $index }}" style="background: rgba(50, 50, 50, 0.5); border: 2px solid rgba(138, 43, 226, 0.3);">
                                                <div class="aspect-square flex items-center justify-center p-2">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image {{ $index + 1 }}" class="max-w-full max-h-full object-contain">
                                                </div>
                                                <div class="absolute top-2 right-2 text-white text-xs px-2 py-1 rounded" style="background: rgba(0, 0, 0, 0.7);">
                                                    {{ $index + 1 }}
                                                </div>
                                                <button 
                                                    type="button"
                                                    onclick="removeImage({{ $index }}, '{{ $image->image_path }}')"
                                                    class="absolute top-2 left-2 text-white rounded-full p-1.5 shadow-lg transition-all opacity-0 group-hover:opacity-100"
                                                    style="background: linear-gradient(135deg, #DC2626, #991B1B);"
                                                    onmouseover="this.style.transform='scale(1.1)'"
                                                    onmouseout="this.style.transform='scale(1)'"
                                                    title="Remove image"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="remove_images" id="remove_images" value="">
                                </div>
                            @endif

                            <div class="border-2 border-dashed rounded-lg p-4 transition-colors cursor-pointer" style="border-color: rgba(138, 43, 226, 0.3); background: rgba(138, 43, 226, 0.05);" id="drop-zone">
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
                                    <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48" style="color: #8A2BE2;">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm" style="color: #B0B0B0;">
                                        <span class="font-semibold" style="color: #8A2BE2;">Click to upload new images</span> or drag and drop
                                    </p>
                                    <p class="mt-1 text-xs" style="color: #6B7280;">Select 1-10 images • PNG, JPG, GIF, WebP • 5MB each</p>
                                </label>
                            </div>
                            <div id="images-preview-grid" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-2 hidden"></div>
                            @error('images.*') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium mb-2" style="color: #E0E0E0;">Title (Max 100 characters)</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $post->title) }}"
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
                                style="background: rgba(50, 50, 50, 0.5); border: 1px solid rgba(138, 43, 226, 0.3); color: #E0E0E0;"
                                onfocus="this.style.borderColor='rgba(138, 43, 226, 0.6)'; this.style.boxShadow='0 0 0 3px rgba(138, 43, 226, 0.1)'"
                                onblur="this.style.borderColor='rgba(138, 43, 226, 0.3)'; this.style.boxShadow='none'"
                                required
                            >{{ old('body', $post->body) }}</textarea>
                            @error('body') <span class="text-sm" style="color: #EF4444;">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="is_published" 
                                    value="1" 
                                    {{ old('is_published', $post->is_published) ? 'checked' : '' }}
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
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'"
                            >
                                Update Post
                            </button>
                            <a 
                                href="{{ route('post.show', $post->slug) }}" 
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
</x-app-layout>

<script>
let removedImages = [];

function removeImage(index, imageData) {
    if (confirm('Are you sure you want to remove this image?')) {
        // Parse image data if it's a JSON string
        let imagePath;
        try {
            const parsed = JSON.parse(imageData);
            imagePath = parsed.image_path || imageData;
        } catch (e) {
            imagePath = imageData;
        }
        
        // Add to removed images array (just the path)
        removedImages.push(imagePath);
        document.getElementById('remove_images').value = JSON.stringify(removedImages);
        
        // Remove from UI
        const imageElement = document.getElementById(`image-${index}`);
        imageElement.style.transition = 'all 0.3s ease';
        imageElement.style.opacity = '0';
        imageElement.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            imageElement.remove();
            
            // Check if all images are removed
            const grid = document.getElementById('current-images-grid');
            if (grid && grid.children.length === 0) {
                grid.parentElement.remove();
            }
        }, 300);
    }
}

function previewMultipleImages(event) {
    const files = Array.from(event.target.files).slice(0, 10);
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
                         class="w-full h-32 object-cover rounded-lg transition-all"
                         style="border: 2px solid rgba(138, 43, 226, 0.3);"
                         alt="Preview ${index + 1}">
                    <div class="absolute top-1 right-1 text-white text-xs px-2 py-1 rounded"
                         style="background: rgba(0, 0, 0, 0.7);">
                        ${index + 1}
                    </div>
                `;
                grid.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Drag and drop
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('images');

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
            previewMultipleImages({ target: fileInput });
        }
    }, false);
}
</script>
