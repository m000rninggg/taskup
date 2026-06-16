@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'breeze-input']) }}>

