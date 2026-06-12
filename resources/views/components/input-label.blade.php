@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#C2C2D4]']) }}>
    {{ $value ?? $slot }}
</label>

