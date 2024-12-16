<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-[#3525B3] border border-transparent rounded-[30px] font-semibold text-sm text-white tracking-widest hover:bg-[#4933f3] focus:bg-[#4933f3] active:bg-[#4933f3] hover:bg-[#4933f3] hover:shadow-[0_0_.5rem_#3525B3] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
