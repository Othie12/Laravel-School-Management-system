@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="row">
        <div class="col-sm-6 col-md-6">

<form method="POST" action="{{ route('subject-reg') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Subject Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Classes -->
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

    </div>
    <div class="col-sm-6 col-md-6">
        <table class="table table-striped table-hover">
            @foreach ($subjects as $subject)
                <tr>
                    <th>{{ $subject->name }}</th>
                    <td><a href="{{ route('subject-edit', ['id' => $subject->id]) }}"><button class="btn btn-info">Edit</button></a></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>


</x-guest-layout>


@endsection
