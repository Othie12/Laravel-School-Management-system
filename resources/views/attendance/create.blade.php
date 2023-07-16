@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="row">
        <div class="col-sm-3 col-md-3"></div>
        <div class="col-sm-6 col-md-6">
            <h3 class="text-info"><u><b>Mark the students who have attended today<b></u></h3>
            <form method="POST" action="{{ route('attendance.store') }}">
                @csrf

                @foreach ($class->students as $student)
                    <div class="mt-4">
                        @if($student->attendance()->where('date', $tday)->first() !== null)
                            <input type="checkbox" name="student_ids[]" id="{{ $student->id }}" value="{{ $student->id }}" checked>
                            {{ $student->name }}
                        @else
                            <input type="checkbox" name="student_ids[]" id="{{ $student->id }}" value="{{ $student->id }}">
                            {{ $student->name }}
                        @endif
                    </div>
                @endforeach

                <div class="mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Record attendance') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="col-sm-3 col-md-3"></div>
    </div>
</x-guest-layout>

@endsection
