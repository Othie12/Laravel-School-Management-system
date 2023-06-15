@extends('layouts.app')

@section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('grading.update') }}">
        @csrf
        @method('patch')

<table class="table table-hover table-striped" >
    <h2>SET GRADING</h2>
    <thead>
        <tr>
            <th>Marks</th>
            <th>Aggregate</th>
            <th>Comment</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($gradings as $grading)
        <tr>
            <td> {{ $grading->marks_from }} - {{ $grading->marks_to }}</td>
            <td>
                <select name="agg[]" id="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="{{ $grading->grade }}">{{ $grading->grade }}</option>
                    <option value="1">D1</option>
                    <option value="2">D2</option>
                    <option value="3">C3</option>
                    <option value="4">C4</option>
                    <option value="5">C5</option>
                    <option value="6">C6</option>
                    <option value="7">P7</option>
                    <option value="8">P8</option>
                    <option value="9">F9</option>
                </select>
            </td>
            <td><input type="text" name="remark[]" id="{{ $grading->id }}" value="{{ $grading->remark }}" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></td>
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
</x-guest-layout>
@endsection
