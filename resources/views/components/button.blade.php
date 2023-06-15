<!-- resources/views/components/button.blade.php -->

@props(['type' => 'submit'])

<button {{ $attributes->merge(['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded']) }} type="{{ $type }}">
    {{ $slot }}
</button>