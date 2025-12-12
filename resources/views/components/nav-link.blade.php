@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1  border-orange-500 text-sm font-medium leading-5 text-orange-400 focus:outline-none focus:border-orange-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 pt-1  border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-orange-400 hover:border-orange-400/40 focus:outline-none focus:text-orange-400 focus:border-orange-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
