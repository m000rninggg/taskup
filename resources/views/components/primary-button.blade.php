<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#282840] border border-[#2D2B3E] rounded-md font-semibold text-xs text-[#20E6C3] uppercase tracking-widest hover:bg-[#339989] hover:text-[#FFFFFF] focus:bg-[#339989] active:bg-[#282840] focus:outline-none focus:ring-2 focus:ring-[#20E6C3] focus:ring-offset-2 focus:ring-offset-[#1C1A26] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

