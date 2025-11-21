<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                {{ __('My Feedback') }}
            </h2>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('reports.create') }}" 
                    class="inline-flex items-center px-4 py-2 text-white rounded-lg font-semibold transition-all"
                    style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                    onmouseover="this.style.transform='scale(1.05)'"
                    onmouseout="this.style.transform='scale(1)'"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Submit Feedback
            </a>
            <x-info-button id="Feedback" title="About Feedback" modal-title="Feedback" subtitle="Report & Suggest">
                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Tentang Feedback</h3>
                    <p style="color: #9CA3AF; line-height: 1.6;">
                        Halaman Feedback adalah tempat untuk melaporkan bug, memberikan saran, atau mengirim feedback lainnya kepada tim BLOGMOUS. Kami sangat menghargai masukan Anda untuk membuat platform ini lebih baik.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-3" style="color: #E0E0E0;">Fitur Feedback</h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Report Bug</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Laporkan bug atau masalah teknis yang Anda temukan</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Suggest Feature</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Berikan saran fitur baru yang ingin Anda lihat</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(138, 43, 226, 0.2);">
                                <svg class="w-4 h-4" style="color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-1" style="color: #E0E0E0;">Track Status</h4>
                                <p class="text-sm" style="color: #9CA3AF;">Lihat status feedback yang sudah Anda kirim</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-info-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12" style="background-color: var(--bg-primary);">
        <div class="px-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg" style="background: rgba(34, 197, 94, 0.2); border: 1px solid rgba(34, 197, 94, 0.5); color: #4ADE80;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($reports as $report)
                    <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold" style="color: #E0E0E0;">
                                        {{ $report->type === 'bug' ? '🐛' : '💡' }} {{ $report->title }}
                                    </h3>
                                    <p class="text-sm mt-1" style="color: #9CA3AF;">
                                        <span class="px-2 py-0.5 rounded text-xs font-medium" style="{{ $report->type === 'bug' ? 'background: rgba(239, 68, 68, 0.2); color: #FCA5A5;' : 'background: rgba(251, 191, 36, 0.2); color: #FCD34D;' }}">
                                            {{ $report->type === 'bug' ? 'Bug Report' : 'Suggestion' }}
                                        </span>
                                        • Submitted {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold" 
                                    style="{{ $report->status === 'resolved' ? 'background: rgba(34, 197, 94, 0.2); color: #4ADE80;' : ($report->status === 'in_progress' ? 'background: rgba(251, 191, 36, 0.2); color: #FCD34D;' : 'background: rgba(138, 43, 226, 0.2); color: #C084FC;') }}">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </div>
                            <p style="color: #B0B0B0;">{{ $report->description }}</p>
                        </div>
                    </div>
                @empty
                    <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background: rgba(30, 30, 30, 0.95); border: 1px solid rgba(138, 43, 226, 0.2);">
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-16 w-16 mb-4" style="color: rgba(138, 43, 226, 0.5);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-medium mb-2" style="color: #E0E0E0;">No feedback yet</h3>
                            <p class="mb-4" style="color: #9CA3AF;">Found a bug or have a suggestion? Let us know!</p>
                            <a 
                                href="{{ route('reports.create') }}" 
                                class="inline-flex items-center px-4 py-2 text-white rounded-lg font-semibold transition-all"
                                style="background: linear-gradient(135deg, #8A2BE2, #5A189A);"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'"
                            >
                                Submit Your First Feedback
                            </a>
                        </div>
                    </div>
                @endforelse

                @if($reports->hasPages())
                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
