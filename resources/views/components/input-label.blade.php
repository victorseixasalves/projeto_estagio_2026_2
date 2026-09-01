@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#16151A] dark:text-white']) }}>
    {{ $value ?? $slot }}
</label>