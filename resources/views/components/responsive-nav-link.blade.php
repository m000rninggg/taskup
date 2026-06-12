@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#20E6C3] text-start text-base font-medium text-[#FFFFFF] bg-[#282840] focus:outline-none focus:text-[#FFFFFF] focus:bg-[#282840] focus:border-[#20E6C3] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#C2C2D4] hover:text-[#20E6C3] hover:bg-[#282840] hover:border-[#2D2B3E] focus:outline-none focus:text-[#20E6C3] focus:bg-[#282840] focus:border-[#2D2B3E] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

