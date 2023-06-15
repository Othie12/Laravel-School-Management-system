@props(['value'])

<label {{ $attributes->merge(['class' => 'font-bold text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>





