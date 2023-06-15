@extends('layouts.app')

@section('content')

<x-guest-layout>

<form method="POST" action="{{ route('subject-reg') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Subject Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Class teacher -->
        <div class="mt-4">
            <x-input-label for="classes" :value="__('Classes that study this subject')" />
            @foreach ($classes as $class)
                <input type="checkbox" name="classes[]" id="{{$class->name}}" value="{{ $class->id }}"> {{$class->name}}<br>
            @endforeach   
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


@endsection