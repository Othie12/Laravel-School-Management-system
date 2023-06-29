@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-300 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:bg-gray-700 rounded-md shadow-sm']) !!}>
