@extends('layouts.app')

@section('content')

<x-guest-layout>

<form method="POST" action="{{ route('subject-update', ['id' => $subject->id]) }}">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Subject Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $subject->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update Name') }}
            </x-primary-button>
        </div>
    </form>



<form method="POST" action="{{ route('subject-update-classes', ['id' => $subject->id]) }}">
    @csrf
    @method('patch')
        <!-- Classes -->

        <div class="mt-4">
            <h3 class="text-info">Classes currently learnt by this subject.</h3>
            <ul>
                @foreach ($subject->classes as $class)
                    <li> {{ $class->name }} </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            <x-input-label for="classes" :value="__('Choose classes you want to assign to this subject')" />
            @foreach ($classes as $class)
                <input type="checkbox" name="classes[]" id="{{$class->name}}" value="{{ $class->id }}"> {{$class->name}}<br>
            @endforeach
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update Classes') }}
            </x-primary-button>
        </div>
    </form>


</x-guest-layout>


@endsection
