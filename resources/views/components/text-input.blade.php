@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => '!border-white/10 !bg-[#09090b] !text-white placeholder:text-gray-300 focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm pointer-events-auto']) }}>