@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Sex -->
        <div class="mt-4">
            <x-input-label for="sex" :value="__('Sex')" />
            <x-text-input id="m" type="radio" name="sex" value="m" />Male
            <x-text-input id="f" type="radio" name="sex" value="f" />Female
        </div>

        <!-- Contact -->
        <div class="mt-4">
            <x-input-label for="contact" :value="__('Contact')" />
            <x-text-input id="contact" type="tel" name="contact" :value="old('contact')" />
        </div>

        <!-- Post -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select name="role" id="role"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="none">None</option>
                    <option value="head_teacher">Head teacher</option>
                    <option value="bursar">Bursar</option>
                    <option value="dos">DOS</option>
                    <option value="secretary">Secretary</option>
                    <option value="sports">Sports teacher</option>
                    <option value="Other">Other</option>
            </select>
        </div>


        <!-- Contact -->
        <div class="mt-4">
            <x-input-label for="picture" :value="__('Picture')" />
            <x-text-input id="picture" type="file" name="picture" />
        </div>

        <!-- Subjects -->
        <div class="mt-4">
            <x-input-label for="subjects" :value="__('Subjects taught by this teacher')" />
            @foreach ($subjects as $subject)
                <input type="checkbox" name="subjects[]" id="{{$subject->name}}" value="{{ $subject->id }}"> {{$subject->name}}<br>
            @endforeach
        </div>

        <!-- classes -->
        <div class="mt-4">
            <x-input-label for="classes" :value="__('Classes taught by this teacher')" />
            @foreach ($classes as $class)
                <input type="checkbox" name="classes[]" id="{{$class->name}}" value="{{ $class->id }}"> {{ $class->name }}<br>
            @endforeach
        </div>

        <!-- Password -->
         <!--
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        -->
        <!-- Confirm Password -->
         <!--
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        -->
        <!--
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        -->
        <div>
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<div class="row">

    @foreach ($teachers as $teacher)
    <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
        @if ($teacher->value('profile_pic_filepath'))
            <img src="{{ asset('storage/' . $teacher->value('profile_pic_filepath')) }}" alt="Profile Image" width="100" class="rounded-md mr-2" style="border-radius: 5%">
        @else
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        @endif
</div>
        <div class="caption">
        <h3> {{ $teacher->name }} </h3>
        <p>
            <a href="profile-other?user_id={{ $teacher->id }}" class="btn btn-primary" role="button">
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


@endsection
