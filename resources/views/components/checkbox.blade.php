@props(['name', 'value' => null])

@php
    $attributes = $attributes->class([
        'form-checkbox',
        'text-indigo-600' => old($name, $attributes['value'] ?? $value) == $value,
    ]);
@endphp

<input
    type="checkbox"
    {{ $attributes->merge(['name' => $name, 'id' => $name]) }}
    {{ $attributes->has('value') ? 'value="'.$value.'"' : '' }}
    {{ old($name) ? 'checked' : '' }}
>