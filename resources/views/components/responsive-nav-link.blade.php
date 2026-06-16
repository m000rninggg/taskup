@props(['active'])

@php
$classes = ($active ?? false)
            ? 'breeze-responsive-link breeze-responsive-link-active'
            : 'breeze-responsive-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

