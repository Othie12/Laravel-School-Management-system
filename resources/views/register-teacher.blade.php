@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8">
        <h1 class="text-2xl font-bold mb-8">Staff Registration Form</h1>
        <div class="max-w-md mx-auto">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-input-text id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-validation-error :name="'name'" />
                </div>

                <!-- Sex -->
                <div class="mb-4">
                    <x-input-label for="sex" :value="__('Sex')" />
                    <select id="sex" name="sex" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Select Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <x-input-validation-error :name="'sex'" />
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-input-text id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-validation-error :name="'email'" />
                </div>

                <!-- Class Teacher -->
                <div class="mb-4">
                    <x-input-label for="classteacher" :value="__('Class Teacher')" />
                    <select id="classteacher" name="classteacher" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Select Class --</option>
                        <option value="P.1">P.1</option>
                        <option value="P.2">P.2</option>
                        <option value="P.3">P.3</option>
                        <option value="P.4">P.4</option>
                        <option value="P.5">P.5</option>
                        <option value="P.6">P.6</option>
                        <option value="P.7">P.7</option>
                    </select>
                    <x-input-validation-error :name="'classteacher'" />
                </div>

                <!-- Post -->
                <div class="mb-4">
                    <x-input-label for="post" :value="__('Post')" />
                    <select id="post" name="post" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">-- Select post --</option>
                        <option value="hm">Head teacher</option>
                        <option value="bursar">Bursar</option>
                        <option value="dos">D.O.S</option>
                        <option value="deputy">Deputy head teacher</option>
                        <option value="secretary">Secretary</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-validation-error :name="'post'" />
                </div>

                 <!-- contact -->
                 <div class="mb-4">
                    <x-input-label for="contact" :value="__('Contact')" />
                    <x-input-text id="contact" class="block mt-1 w-full" type="tel" name="contact" :value="old('contact')" required autofocus />
                    <x-input-validation-error :name="'contact'" />
                </div>

                <div class='mb-4'>
                <x-input-label for="subjects_taught" :value="__('Subjects Taught')" />

                <div class="mt-2 space-y-2">
                    <x-checkbox id="maths" name="subjects_taught[]" :value="'maths'" :checked="in_array('maths', old('subjects_taught', []))" />
                    <x-input-label for="maths" :value="__('Mathematics')" />

                    <x-checkbox id="english" name="subjects_taught[]" :value="'english'" :checked="in_array('english', old('subjects_taught', []))" />
                    <x-input-label for="english" :value="__('English Language')" />

                    <x-checkbox id="science" name="subjects_taught[]" :value="'science'" :checked="in_array('science', old('subjects_taught', []))" />
                    <x-input-label for="science" :value="__('Science')" />

                    <x-checkbox id="social_studies" name="subjects_taught[]" :value="'social_studies'" :checked="in_array('social_studies', old('subjects_taught', []))" />
                    <x-input-label for="social_studies" :value="__('Social Studies')" />

                    <!-- Add more checkboxes for each subject here -->
                </div>

                <x-input-error :messages="$errors->get('subjects_taught')" class="mt-2" />
                </div>

                <div class="mb-4">
                <x-input-text id="submit1" class="block mt-1 w-full" type="submit" name="submit1" :value="old('submit')" required autofocus />
                </div>


<div class="row">

    @foreach ($teachers as $teacher)
    <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
        @if ($teacher->value('profile_pic_filepath'))
            <img src="{{ asset('storage/' . $teacher->value('profile_pic_filepath')) }}" alt="Profile Image" class="rounded-md mr-2 w-full aspect-square">
        @else
            <x-application-logo :width="__('100%')" />
        @endif
</div>
        <div class="caption">
        <h3> {{ $teacher->name }} </h3>
        <p>
            <a href="class-update?user_id={{ $class->id }}" class="btn btn-primary" role="button">
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
