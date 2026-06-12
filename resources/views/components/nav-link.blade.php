@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#20E6C3] text-sm font-medium leading-5 text-[#FFFFFF] focus:outline-none focus:border-[#20E6C3] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#C2C2D4] hover:text-[#20E6C3] hover:border-[#2D2B3E] focus:outline-none focus:text-[#20E6C3] focus:border-[#2D2B3E] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

