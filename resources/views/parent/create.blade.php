@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="row">
        <div class="col-sm-6 col-md-6">
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
                <input type="hidden" name="role" value="parent">

                <!-- Contact -->
                <div class="mt-4">
                    <x-input-label for="picture" :value="__('Picture')" />
                    <x-text-input id="picture" type="file" name="picture" />
                </div>

                <div>
                    <x-primary-button class="ml-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="col-sm-6 col-md-6">
            <h2>retgistered Parents</h2>
            <div class="row">
            @foreach ($parents as $parent)
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail">
                @if ($parent->profile_pic_filepath)
                    <img src="{{ asset('storage/' . $parent->profile_pic_filepath) }}" alt="Profile Image" width="100%" class="rounded-md mr-2" style="border-radius: 5%">
                @else
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
                @endif
            </div>
                <div class="caption">
                <h3> {{ $parent->name }} </h3>
                <p>
                    <a href="profile-other?user_id={{ $parent->id }}" class="btn btn-primary" role="button">
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
