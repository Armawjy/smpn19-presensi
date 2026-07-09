@props(['id', 'title'])
<div 
    x-data="{ show: false }" 
    x-show="show" 
    @open-modal.window="if ($event.detail.id === '{{ $id }}') show = true"
    @close-modal.window="if ($event.detail.id === '{{ $id }}') show = false"
    x-cloak 
    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
>
    <!-- Background overlay -->
    <div 
        x-show="show" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false" 
        class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
    ></div>

    <!-- Modal box -->
    <div 
        x-show="show" 
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-2xl overflow-hidden shadow-2xl border border-gray-100 transform transition-all w-full max-w-lg z-10"
    >
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
