@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'breeze-status']) }}>
        {{ $status }}
    </div>
@endif

