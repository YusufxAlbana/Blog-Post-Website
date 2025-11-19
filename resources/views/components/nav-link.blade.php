@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out';
$style = ($active ?? false)
            ? 'color: #8A2BE2; border-color: #8A2BE2;'
            : 'color: rgba(224, 224, 224, 0.7);';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="{{ $style }}" onmouseover="this.style.color='#8A2BE2'" onmouseout="this.style.color='{{ ($active ?? false) ? '#8A2BE2' : 'rgba(224, 224, 224, 0.7)' }}'">
    {{ $slot }}
</a>
