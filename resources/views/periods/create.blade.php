@extends('layouts.app')

@section('content')

<x-guest-layout>
    <form method="POST" onsubmit="validate()" action="{{ route('period.create') }}" class="dark:text-gray-300 dark:border-gray-300">
        @csrf

<div class="mt-4">
    <x-input-label for="first_begin" :value="__('First term')" />
<table>
    <tr>
        <th>Begins</th>
        <th>Ends</th>
    </tr>
    <tr>
        <td><x-text-input class="dateInput" id="first_begin" type="date" name="first_begin" :value="old('first_begin')" required /></td>
        <td><x-text-input class="dateInput" id="first_end" type="date" name="first_end" :value="old('first_end')" required /></td>
    </tr>
</table>
</div>

<div class="mt-4">
    <x-input-label for="second_begin" :value="__('Second term')" />
<table>
    <tr>
        <th>Begins</th>
        <th>Ends</th>
    </tr>
    <tr>
        <td><x-text-input class="dateInput" id="second_begin" type="date" name="second_begin" :value="old('second_begin')" required /></td>
        <td><x-text-input class="dateInput" id="second_end" type="date" name="second_end" :value="old('second_end')" required /></td>
    </tr>
</table>
</div>

<div class="mt-4">
    <x-input-label for="third_begin" :value="__('Third term')" />
<table>
    <tr>
        <th>Begins</th>
        <th>Ends</th>
    </tr>
    <tr>
        <td><x-text-input class="dateInput" id="third_begin" type="date" name="third_begin" :value="old('third_begin')" required /></td>
        <td><x-text-input class="dateInput" id="third_end" type="date" name="third_end" :value="old('third_end')" required /></td>
    </tr>
</table>
</div>
        <div>
            <x-primary-button class="ml-4">
                {{ __('Set') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
@endsection

<script>
    function validate(){
        alert('djkfd');
        let fb = new Date(document.querySelector('[name=first_begin]').value);
        let fe = new Date(document.querySelector('[name=first_end]').value);
        let sb = new Date(document.querySelector('[name=second_begin]').value);
        let se = new Date(document.querySelector('[name=secod_end]').value);
        let tb = new Date(document.querySelector('[name=third_begin]').value);
        let te = new Date(document.querySelector('[name=first_end]').value);
        var currentYear = new Date().getFullYear();

        event.preventDefault();
        alert(fb);
        if(fb.getFullYear() > currentYear ) {
            alert('Please select dates within the current year');
            //return false;
        }
        //return true;
    }
</script>
