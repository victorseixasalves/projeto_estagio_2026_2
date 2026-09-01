@props(['disabled' => false])

<input @disabled($disabled) {!! $attributes->merge(['class' => 'rounded-lg bg-[#F5F3F0] dark:bg-white/5 border-black/15 dark:border-white/15 text-[#16151A] dark:text-white focus:border-[#1B7A43] focus:ring-[#1B7A43] shadow-sm']) !!}>