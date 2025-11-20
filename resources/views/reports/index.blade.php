<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight" style="color: #E0E0E0;">
                {{ __('My Feedback') }}
            </h2>
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
