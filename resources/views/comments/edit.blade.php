@extends('layouts.app')

@section('content')
<x-guest-layout>
    <form method="POST" action="{{ route('comments.update') }}">
        @csrf
        @method('patch')

<table class="table table-hover table-striped" >
    <h2>SET COMMENTS</h2>
    <tr>
        <th>Percentile</th>
        <th>Classteacher's Comment</th>
        <th>Headteacher's Comment</th>
    </tr>
@foreach ($comments as $comment)
    <tr>
        <td>
            @switch($comment->agg_from)
                @case(0)
                First
                    @break
                @case(10)
                Second
                    @break
                @case(20)
                Third
                    @break
                @case(30)
                Fourth
                    @break
                @case(40)
                Fifth
                    @break
                @case(50)
                Sixth
                    @break
                @case(60)
                Seventh
                    @break
                @case(70)
                Eigth
                    @break
                @case(80)
                Nineth
                    @break
                @case(90)
                Tenth
                    @break
                @default
                --Error--
            @endswitch
            </td>
            <input type="hidden" name="ids[]" value="{{ $comment->id }}">
        <td><textarea name="ctcomms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-300 dark:bg-gray dark:text-gray-300 dark:bg-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required >{{ $comment->ct_comm }}</textarea></td>
        <td><textarea {{ Auth::user()->role === 'head_teacher' ? 'required' : 'disabled' }} name="htcomms[]" id="" cols="30" rows="1" class="border-gray-300 dark:border-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:bg-black-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" >{{ $comment->ht_comm }}</textarea></td>
    </tr>
@endforeach
</table>

        <div>
            <x-primary-button class="ml-4">
                {{ __('Set') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection
