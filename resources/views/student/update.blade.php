@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('student.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $student->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Sex -->
        <div class="mt-4">
            <x-input-label for="sex" :value="__('Sex')" />
            @if ($student->sex === 'm')
                <x-text-input id="m" type="radio" name="sex" value="m" checked />Male
                <x-text-input id="f" type="radio" name="sex" value="f" />Female
            @else
                <x-text-input id="m" type="radio" name="sex" value="m" />Male
                <x-text-input id="f" type="radio" name="sex" value="f" checked />Female
            @endif

        </div>

        <!-- dob -->
        <div class="mt-4">
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" type="date" name="dob" :value="old('dob', $student->dob)" />
        </div>


        <!-- Class -->
        <div class="mt-4">
            <x-input-label for="class_id" :value="__('Class')" />
            <select name="class_id" id="class"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="{{ $student->class_id }}"> {{ $student->class->name }} </option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach

            </select>
        </div>


        <!-- Parent -->
        <div class="mt-4">
            <x-input-label for="parent" :value="__('Parent')" />
            <select name="parent" id="parent"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            <option value="{{ $student->parent !== null ? $student->parent->id : ''}}">{{ $student->parent !== null ? $student->parent->name : '__Select Parent__' }}</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
            @endforeach

            </select>
        </div>


        <!-- parent's relationship -->
        <div class="mt-4">
            <x-input-label for="relationship" :value="__('Parent / guardian relationship')" />
            <select name="relationship" id="relationship"   class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="">-- Choose --</option>
                    <option value="mother">Mother</option>
                    <option value="father">Father</option>
                    <option value="sister">Sister</option>
                    <option value="brother">Brother</option>
                    <option value="aunt">Aunt</option>
                    <option value="uncle">Uncle</option>
                    <option value="grandparent">Grand parent</option>
            </select>
        </div>

        <input type="hidden" name="id" value="{{ $student->id }}">

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>


    <div class="accordion" id="profilepic">
        <form action="{{ route('student.update.photo') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <!-- picture -->
            <div class="mt-4">
                <x-input-label for="picture" :value="__('Picture')" />
                <a href="{{ 'storage/' . $student->profile_pic_filepath }}"><img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="100" class="rounded-md mr-2"></a>
                <x-text-input id="picture" type="file" name="picture" required/>
            </div>

            <input type="hidden" name="id" value="{{ $student->id }}">

            <div class="mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-guest-layout>


<!--<x-guest-layout>-->
@if ($student->parent !== null)
  <div class="accordion" id="par">
        <div class="accordion-group">
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#par"
                href="#collapseOne">
                    Parent info
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner">
                    <table class="table" >
                        <caption>Parent info</caption>
                        <h1 align='center'>Parent info</h1>
                        <tr>
                            <th>Parent's name</th>
                            <td>{{ $student->parent->name }}</td>
                        </tr>
                        <tr>
                            <th>Parent's email</th>
                            <td>{{ $student->parent->email }}</td>
                        </tr>
                        <tr>
                            <th>Parent's sex</th>
                            <td>{{ $student->parent->sex }}</td>
                        </tr>
                        <tr>
                            <th>Parent's contact</th>
                            <td>{{ $student->parent->contact }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
<!--</x-guest-layout>-->

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Student') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once this student is deleted, all of his/her resources and data will be permanently deleted. Before deleting this student, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion')"
    >{{ __('Delete Student') }}</x-danger-button>

    <x-modal name="confirm-student-deletion" :show="$errors->studentDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('student.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this student?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once this student is deleted, all of his/her resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <input type="hidden" name="id" value="{{ $student->id }}">

                <x-input-error :messages="$errors->studentDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Student') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>


@endsection

