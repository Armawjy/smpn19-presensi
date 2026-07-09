<div class="bg-white/80 backdrop-blur-md rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition duration-300">
    @if(isset($title))
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">{{ $title }}</h3>
    @endif
    {{ $slot }}
</div>
