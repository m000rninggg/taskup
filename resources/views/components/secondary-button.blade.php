<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-[#282840] border border-[#2D2B3E] rounded-md font-semibold text-xs text-[#C2C2D4] uppercase tracking-widest shadow-sm hover:bg-[#339989] hover:text-[#FFFFFF] focus:outline-none focus:ring-2 focus:ring-[#20E6C3] focus:ring-offset-2 focus:ring-offset-[#1C1A26] disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

