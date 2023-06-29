@extends('layouts.app')

@section('content')
    <x-slot name="header" class="dark:bg-gray-700">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="mt-4 dark:bg-gray-800">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

@if (Auth::user()->id === $user->id)
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 dark:bg-gray-800 mt-4" id="profilepic">
    <form action="{{ route('profile.update.photo') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- picture -->
        <div class="mt-4">
            <x-input-label for="picture" :value="__('Picture')" />
            <a href="{{ 'storage/' . Auth::user()->profile_pic_filepath }}"><img src="{{ asset('storage/' . Auth::user()->profile_pic_filepath) }}" alt="Profile Image" width="100" class="rounded-md mr-2"></a>
            <x-text-input id="picture" type="file" name="picture" required/>
        </div>

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
</div>


    <div class="p-4 sm:p-8 bg-whit dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="mt-4">
            @include('profile.partials.update-password-form')
        </div>
    </div>

@endif

@if (Auth::user()->id !== $user->id && (Auth::user()->role === 'admini' || Auth::user()->role === 'dos') && $user->role !== 'parent')
    <div class="p-4 sm:p-8 bg-whit dark:bg-gray-800 shadow sm:rounded-lg mt-4">
        <div class="mt-4 dark:bg-gray-800">
            @include('profile.partials.update-classses-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-whit dark:bg-gray-800 shadow sm:rounded-lg mt-4">
        <div class="mt-4 dark:bg-gray-800">
            @include('profile.partials.update-subjects-form')
        </div>
    </div>
@endif


            <div class="p-4 sm:p-8 bg-whit dark:bg-gray-800 shadow sm:rounded-lg mt-4">
                <div class="mt-4 dark:bg-gray-800">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
