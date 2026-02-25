@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-black/40 border-white/10 focus:border-blue-500 focus:ring-blue-500/50 rounded-lg shadow-sm text-white']) }}>
