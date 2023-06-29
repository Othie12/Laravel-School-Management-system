@extends('layouts.app')

@section('content')

<x-guest-layout>
<form method="POST" action="{{ route('class-update', ['id' => $clas->id]) }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Class Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $clas->name) " required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Class teacher -->
        <div class="mt-4">
            <x-input-label for="classteacher" :value="__('Class Teacher')" />
            <select name="classteacher" id="classteacher"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="{{ $clas->classteacher()->value('id') }}">-- {{ $clas->classteacher()->value('name') }} --</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach

            </select>
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


@endsection
