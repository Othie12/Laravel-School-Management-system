@props(['name', 'label'])

<div>
    <label for="{{ $name }}" class="block font-medium text-sm text-gray-700">{{ 'label' }}</label>
    <input type="text" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}>
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>