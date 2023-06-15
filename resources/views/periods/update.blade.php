@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('period.update') }}">
        @csrf
        @method('patch')

        @foreach ($periods as $period)
            <div class="mt-4">
                <x-input-label for="{{ $period->name }}" :value="__($period->name)" />
            <table>
                <tr>
                    <th>Begins</th>
                    <th>Ends</th>
                </tr>
                <tr>
                    <td><x-text-input id="{{ 'start' . $period->id }}" type="date" name="start[]" :value="old('start' . $period->id, $period->date_from)" /></td>
                    <td><x-text-input id="{{ 'end' . $period->id }}" type="date" name="end[]" :value="old('end' . $period->id, $period->date_to)" /></td>
                </tr>
            </table>
            </div>
        @endforeach

        <div>
            <x-primary-button class="ml-4">
                {{ __('Set') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
@endsection
