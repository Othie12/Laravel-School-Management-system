@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('student.create') }}" enctype="multipart/form-data" class="dark:text-gray-300">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Sex -->
        <div class="mt-4">
            <x-input-label for="sex" :value="__('Sex')" />
            <x-text-input id="m" type="radio" name="sex" value="m" />Male
            <x-text-input id="f" type="radio" name="sex" value="f" />Female
        </div>

        <!-- dob -->
        <div class="mt-4">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" type="date" name="dob" :value="old('dob')" />
        </div>


        <!-- picture -->
        <div class="mt-4">
            <x-input-label for="picture" :value="__('Picture')" />
            <x-text-input id="picture" type="file" name="picture" />
        </div>

        <!-- Class -->
        <div class="mt-4">
            <x-input-label for="class" :value="__('Class')" />
            <select name="class" id="class"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="">-- Select Class --</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach

            </select>
        </div>


        <!-- Parent -->
        <div class="mt-4">
            <x-input-label for="parent" :value="__('Parent')" />
            <select name="parent" id="parent"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="">-- Select Parent--</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
            @endforeach

            </select>
        </div>

        <!-- parent's relationship -->
        <div class="mt-4">
            <x-input-label for="relationship" :value="__('Parent / guardian relationship')" />
            <select name="relationship" id="relationship"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">-- Choose --</option>
                    <option value="mother">Mother</option>
                    <option value="father">Father</option>
                    <option value="sister">Sister</option>
                    <option value="brother">Brother</option>
                    <option value="aunt">Aunt</option>
                    <option value="uncle">Uncle</option>
                    <option value="grandparent">Grand parent</option>
            </select>
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>



@endsection

