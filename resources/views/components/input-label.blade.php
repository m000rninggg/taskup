@props(['value'])

<label {{ $attributes->merge(['class' => 'breeze-label']) }}>
    {{ $value ?? $slot }}
</label>

