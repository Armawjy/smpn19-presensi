@props(['variant' => 'primary', 'type' => 'submit'])

@php
$classes = 'inline-flex items-center px-4 py-2 text-sm font-semibold rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 ';
if ($variant === 'primary') {
    $classes .= 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500';
} elseif ($variant === 'secondary') {
    $classes .= 'bg-gray-100 hover:bg-gray-200 text-gray-800 focus:ring-gray-300 border border-gray-200';
} elseif ($variant === 'danger') {
    $classes .= 'bg-red-500 hover:bg-red-600 text-white focus:ring-red-500';
} elseif ($variant === 'success') {
    $classes .= 'bg-green-500 hover:bg-green-600 text-white focus:ring-green-500';
}
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
