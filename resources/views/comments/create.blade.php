@extends('layouts.app')

@section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('comments.create') }}">
        @csrf

<table class="table table-hover table-striped" >
    <h2>SET COMMENTS</h2>
    <tr>
        <th>Percentile</th>
        <th>Comment</th>
    </tr>
    <tr>
        <td>First</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Second</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Third</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Fourth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Fifth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Sixth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Seventh</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Eigth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Nineth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
    <tr>
        <td>Tenth</td>
        <td><textarea name="comms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-700 dark:bg-gray dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required ></textarea></td>
    </tr>
</table>

        <div>
            <x-primary-button class="ml-4">
                {{ __('Set') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection
