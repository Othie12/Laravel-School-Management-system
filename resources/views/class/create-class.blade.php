@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <form method="POST" action="{{ route('class-reg') }}">
                @csrf

                <!-- Name -->
                <div class="mt-4">
                    <x-input-label for="name" :value="__('Class Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>


                <!-- Class teacher -->
                <div class="mt-4">
                    <x-input-label for="classteacher" :value="__('Class Teacher')" />
                    <select name="classteacher" id="classteacher"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">-- Select Class teacher--</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach

                    </select>
                </div>

                <div class="mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="col-sm-6 col-md-6 container">
            <h2>Available Classes</h2>
            <div class="row">
            @foreach ($classes as $class)
            <div class="col-sm-6 col-md-6 mt-4">
                <div class="thumbnail">
                @if ($class->classteacher()->value('profile_pic_filepath'))
                    <img src="{{ asset('storage/' . $class->classteacher()->value('profile_pic_filepath')) }}" alt="Profile Image" width="100" class="rounded-md mr-2" style="border-radius: 5%">
                @else
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                @endif
                </div>
                <div class="caption">
                <h3> {{ $class->name }} </h3>
                <p><b>Classteacher: </b>{{$class->classteacher()->value('name')}}</p>
                <p>
                    <a href="{{ route('class-edit', ['id' => $class->id]) }}" class="btn btn-primary" role="button">
                    Edit
                    </a>
                    <a href="#" class="btn btn-default" role="button">
                    View
                    </a>
                </p>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
</x-guest-layout>

@endsection
