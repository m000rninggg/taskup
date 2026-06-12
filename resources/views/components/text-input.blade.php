@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#242236] border-[#2D2B3E] text-[#FFFFFF] placeholder:text-[#8C8CA3] focus:border-[#20E6C3] focus:ring-[#20E6C3] rounded-md shadow-sm']) }}>

