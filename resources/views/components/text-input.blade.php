@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/10 bg-[#09090b] text-white focus:border-red-500 focus:ring-red-500 rounded-md shadow-sm']) }}>
