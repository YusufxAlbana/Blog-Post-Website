<!-- Info Button -->
<button onclick="openInfoModal{{ $id ?? '' }}()" type="button" class="p-2 rounded-full transition-all" style="color: #8A2BE2; border: 2px solid rgba(138, 43, 226, 0.3);" onmouseover="this.style.background='rgba(138, 43, 226, 0.1)'; this.style.borderColor='#8A2BE2'" onmouseout="this.style.background=''; this.style.borderColor='rgba(138, 43, 226, 0.3)'" title="{{ $title ?? 'Information' }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
</button>

<script>
    // Store modal content
    window.infoModalContent{{ $id ?? '' }} = `
        <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.9); z-index: 999999; display: flex; align-items: center; justify-content: center; padding: 20px;" onclick="closeInfoModal{{ $id ?? '' }}()">
            <div style="max-width: 700px; width: 100%; background: #1a1a1a; border: 2px solid #8A2BE2; border-radius: 16px; padding: 32px; position: relative; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
                
                <!-- Close Button -->
                <button onclick="closeInfoModal{{ $id ?? '' }}()" type="button" style="position: absolute; top: 16px; right: 16px; width: 40px; height: 40px; border-radius: 50%; background: rgba(138, 43, 226, 0.2); border: 2px solid #8A2BE2; color: #E0E0E0; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; z-index: 10;" onmouseover="this.style.background='rgba(138, 43, 226, 0.4)'; this.style.transform='scale(1.1)'" onmouseout="this.style.background='rgba(138, 43, 226, 0.2)'; this.style.transform='scale(1)'">
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header -->
                <div style="margin-bottom: 24px; padding-right: 50px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, rgba(138, 43, 226, 0.2), rgba(90, 24, 154, 0.2)); border: 1px solid rgba(138, 43, 226, 0.3); display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 24px; height: 24px; color: #8A2BE2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 style="font-size: 24px; font-weight: bold; color: #E0E0E0; margin: 0;">{{ $modalTitle ?? 'Information' }}</h2>
                            <p style="font-size: 14px; color: #9CA3AF; margin: 0;">{{ $subtitle ?? 'BLOGMOUS' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div style="color: #E0E0E0;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    `;
    
    function openInfoModal{{ $id ?? '' }}() {
        // Create modal element
        const modalDiv = document.createElement('div');
        modalDiv.id = 'infoModalContainer{{ $id ?? '' }}';
        modalDiv.innerHTML = window.infoModalContent{{ $id ?? '' }};
        document.body.appendChild(modalDiv);
        document.body.style.overflow = 'hidden';
    }
    
    function closeInfoModal{{ $id ?? '' }}() {
        const modalContainer = document.getElementById('infoModalContainer{{ $id ?? '' }}');
        if (modalContainer) {
            modalContainer.remove();
        }
        document.body.style.overflow = '';
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeInfoModal{{ $id ?? '' }}();
        }
    });
</script>
