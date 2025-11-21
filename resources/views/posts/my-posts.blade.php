<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                {{ __('My Posts') }}
            </h2>
            <x-info-button id="MyPosts" title="About My Posts" modal-title="My Posts" subtitle="Manage Your Content">
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Kelola Postingan Anda</h3>
                    <p style="color: #9CA3AF; line-height: 1.6;">
                        Halaman ini menampilkan semua postingan yang telah Anda buat. Anda dapat mengedit, menghapus, atau melihat statistik dari setiap postingan.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Fitur My Posts</h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Edit Post</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Ubah judul, konten, atau gambar postingan Anda kapan saja</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Delete Post</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Hapus postingan yang tidak Anda inginkan lagi</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">View Statistics</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Lihat jumlah likes dan komentar pada setiap postingan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-info-button>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg" style="background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.5); color: #4ADE80;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="overflow-hidden shadow-sm sm:rounded-lg transition-all" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);" onmouseover="this.style.borderColor='rgba(138, 43, 226, 0.4)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='rgba(138, 43, 226, 0.2)'; this.style.transform=''">
                        <div class="flex flex-col md:flex-row">
                            @if($post->featured_image)
                                <div class="md:w-1/4">
                                    <img 
                                        src="{{ $post->featured_image_url }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-48 md:h-full object-cover"
                                        style="border-right: 1px solid rgba(138, 43, 226, 0.2);"
                                    >
                                </div>
                            @endif
                            <div class="flex-1 p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold mb-2">
                                            <a href="{{ route('post.show', $post->slug) }}" class="transition-colors" style="color: #E0E0E0;" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='#E0E0E0'">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm mb-4" style="color: #9CA3AF;">
                                            <span>{{ $post->created_at->diffForHumans() }}</span>
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold" style="{{ $post->is_published ? 'background: rgba(34, 197, 94, 0.2); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.3);' : 'background: rgba(234, 179, 8, 0.2); color: #FCD34D; border: 1px solid rgba(234, 179, 8, 0.3);' }}">
                                                {{ $post->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </div>
                                        <div class="prose max-w-none" style="color: rgba(224, 224, 224, 0.8);">
                                            {{ Str::limit(strip_tags($post->body), 200) }}
                                        </div>
                                    </div>
                                    <div class="flex gap-2 ml-4">
                                        <a href="{{ route('post.edit', $post->slug) }}" class="p-2 rounded-lg transition-all" style="background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(202, 138, 4, 0.3)); color: #FCD34D; border: 1px solid rgba(234, 179, 8, 0.5); box-shadow: 0 0 15px rgba(234, 179, 8, 0.2);" onmouseover="this.style.background='linear-gradient(135deg, rgba(234, 179, 8, 0.4), rgba(202, 138, 4, 0.4))'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 0 20px rgba(234, 179, 8, 0.4)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(202, 138, 4, 0.3))'; this.style.transform=''; this.style.boxShadow='0 0 15px rgba(234, 179, 8, 0.2)'" title="Edit Post">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('post.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg transition-all" style="background: linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(185, 28, 28, 0.3)); color: #FCA5A5; border: 1px solid rgba(220, 38, 38, 0.5); box-shadow: 0 0 15px rgba(220, 38, 38, 0.2);" onmouseover="this.style.background='linear-gradient(135deg, rgba(220, 38, 38, 0.4), rgba(185, 28, 28, 0.4))'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 0 20px rgba(220, 38, 38, 0.4)'" onmouseout="this.style.background='linear-gradient(135deg, rgba(220, 38, 38, 0.3), rgba(185, 28, 28, 0.3))'; this.style.transform=''; this.style.boxShadow='0 0 15px rgba(220, 38, 38, 0.2)'" title="Delete Post">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">No posts yet</h3>
                            <p class="mb-4" style="color: #9CA3AF;">You haven't created any posts yet</p>
                            <a href="{{ route('post.create') }}" class="inline-flex items-center px-4 py-2 text-white rounded-xl font-semibold transition-all" style="background: linear-gradient(135deg, #8A2BE2, #5A189A); box-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(138, 43, 226, 0.5)'" onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 15px rgba(138, 43, 226, 0.3)'">
                                Create your first post!
                            </a>
                        </div>
                    </div>
                @endforelse

                @if($posts->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
