@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('requirements.update', ['id' => $req->id]) }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name of requirement')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $req->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Whether the requirement is compulsary or not -->
        <div class="mt-4">
            <x-input-label for="compulsary" :value="__('Compulsary')" />
            @if ($req->compulsary === 'y')
                <x-text-input id="y" type="radio" name="compulsary" value="y" checked/>Yes
                <x-text-input id="n" type="radio" name="compulsary" value="n" />No
            @else
                <x-text-input id="y" type="radio" name="compulsary" value="y" />Yes
                <x-text-input id="n" type="radio" name="compulsary" value="n" checked/>No
            @endif
        </div>


        <!-- quantity -->
        <div class="mt-4">
            <x-input-label for="quantity" :value="__('Quantity')" />
            <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity', $req->quantity)" required autofocus autocomplete="quantity" aria-placeholder="eg 1, 2, 3. Put 0 for uncountable ones forexample 'tour'"/>
            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $req->price)" autofocus autocomplete="price" aria-placeholder="eg 45000. You can skip this if you want"/>
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>



        <!-- Class -->
        <div class="mt-4">
            <x-input-label for="class_id" :value="__('Class')" />
            <select name="class_id" id="class"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="{{ $req->class->id }}">-- {{ $req->class->name }} --</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4">
        <a href="{{ route('class-show', ['id' => $req->class_id])}}"><button class="btn btn-info">Back</button></a>
    </div>
</x-guest-layout>

@endsection

