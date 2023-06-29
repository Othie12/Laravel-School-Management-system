@extends('layouts.app')

@section('content')


<x-guest-layout>

    <form method="POST" action="{{ route('requirements.store') }}" class="dark:text-gray-300">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name of requirement')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" aria-placeholder="djkfd" placeholder="eg Toilet paper"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Whether the requirement is compulsary or not -->
        <div class="mt-4">
            <x-input-label for="compulsary" :value="__('Compulsary')" />
            <x-text-input id="y" type="radio" name="compulsary" value="y" />Yes
            <x-text-input id="n" type="radio" name="compulsary" value="n" />No
        </div>

        <!-- quantity -->
        <div class="mt-4">
            <x-input-label for="quantity" :value="__('Quantity')" />
            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity')" required autofocus autocomplete="quantity" placeholder="eg 1, 2, 3. Put 0 for uncountable ones forexample 'tour'"/>
            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" autofocus autocomplete="price" placeholder="eg 45000. You can skip this if you want"/>
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>



        <!-- Class -->
        <div class="mt-4">
            <x-input-label for="class_id" :value="__('Class')" />
            <select name="class_id" id="class_id"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="">-- Select Class --</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>

@endsection

