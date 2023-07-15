@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4"></div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                <form method="POST" action="{{ route('period.update') }}" class="dark:text-gray-300 dark:border-indigo-500">
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

                    <div class="mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Set') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        <div class="col-sm-4 col-md-4 col-lg-4"></div>
    </div>
</x-guest-layout>
@endsection
