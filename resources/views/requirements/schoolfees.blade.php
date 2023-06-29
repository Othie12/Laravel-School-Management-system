@extends('layouts.app')

@section('content')

<x-guest-layout>

@if ($item === null)
    <form action="{{ route('requirements.store') }}" method="post" class="dark:text-gray-300">
        @csrf

        <div class="mt-4">
            <h2 class="text-bold">School Fees</h2>
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" autofocus autocomplete="price" placeholder="eg 45000" min="0"/>
        </div>

        <input type="hidden" name="name" value="schoolfees">
        <input type="hidden" name="compulsary" value="y">
        <input type="hidden" name="quantity" value="0">
        <input type="hidden" name="class_id" value="{{ $class->id }}">

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
@else
    <form action="{{ route('requirements.update', ['id' => $item->id]) }}" method="post" class="dark:text-gray-300">
        @csrf
        @method('patch')
        <div class="mt-4">
            <h2 class="text-bold">School Fees for {{ $class->name }} </h2>
            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $item->price)" autofocus autocomplete="price" placeholder="eg 45000" min="0"/>
        </div>

        <input type="hidden" name="name" value="schoolfees">
        <input type="hidden" name="compulsary" value="y">
        <input type="hidden" name="quantity" value="0">
        <input type="hidden" name="class_id" value="{{ $class->id }}">

        <div class="mt-4">
            <x-primary-button class="ml-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>
@endif
<div class="mt-4"><a href="{{route('dashboard')}}" align="right"><button class="btn btn-primary">Back</button></a></div>

</x-guest-layout>

@endsection

