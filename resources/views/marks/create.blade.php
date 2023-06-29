@extends('layouts.app')

@section('content')
<x-guest-layout>
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" style="display: flex; justify-content: space-between">
        @foreach ($subjects as $subject)
        <li><a href="#tab{{ $subject->id }}" data-toggle="tab"><button type="button" class="btn btn-primary" style="background-color: deepskyblue"> {{ $subject->name }} </button></a></li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach ($subjects as $subject)
        <div class="tab-pane" id="tab{{ $subject->id }}">

            <form method="POST" action="{{ route('marks.resolve-storage') }}" class="dark:text-gray-300">
                @csrf
                <input type="hidden" name="class_id" value="{{ $clas->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <table class="table table-hover table-striped" >
            <h2 align="center">{{ $subject->name }} :  {{ $clas->name }} </h2>
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Mid term</th>
                    <th>End of term</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td> <img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="30" class="rounded-md mr-2"></td>
                    <td> {{ $student->name }}</td>
                    <input type="hidden" name="students[]" value="{{ $student->id }}">
                    <td><input type="number" name="marks_mid[]" id="mid{{ $student->id }}" value="{{ $m = $student->marks()->where('subject_id', $subject->id)->where('period_id', session('period_id'))->where('type', 'mid')->first() ? $student->marks()->where('subject_id', $subject->id)->where('period_id', session('period_id'))->where('type', 'mid')->first()->mark : 0  }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
                    <td><input type="number" name="marks_end[]" id="end{{ $student->id }}" value="{{ $m = $student->marks()->where('subject_id', $subject->id)->where('period_id', session('period_id'))->where('type', 'end')->first() ? $student->marks()->where('subject_id', $subject->id)->where('period_id', session('period_id'))->where('type', 'end')->first()->mark : 0  }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
                    <td> <i class="icon-eye-open"></i></td>
                </tr>
                @endforeach
            </tbody>

        </table>

                <div>
                    <x-primary-button class="ml-4">
                        {{ __('Set') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>

</x-guest-layout>
@endsection
<!--
     I have to implement forms where each nav tab is a subject, then the section is a
    form containing student's names and their marks to be filled, then a hidden form field
    for subject_id and class_id. The server will then attach the period_id according to the
    current session's period_id. And the type of exam(mid, end, bot) to be stored to the db
-->
