@props(['active'])

@php
$classes = ($active ?? false)
            ? 'breeze-nav-link breeze-nav-link-active'
            : 'breeze-nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

