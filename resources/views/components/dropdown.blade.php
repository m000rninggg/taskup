@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'breeze-dropdown-content'])

@php
$alignmentClasses = match ($align) {
    'left' => 'breeze-dropdown-left',
    'top' => 'breeze-dropdown-top',
    default => 'breeze-dropdown-right',
};

$width = match ($width) {
    '48' => 'breeze-dropdown-width',
    default => $width,
};
@endphp

<div class="breeze-dropdown" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition
            class="breeze-dropdown-menu {{ $width }} {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

