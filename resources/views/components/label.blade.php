@props(['value'])

<label {{ $attributes->merge(['class' => 'font-bold text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>





