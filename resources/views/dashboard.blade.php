@extends('layouts.app')

@section('content')
<div class="jumbotron" align="center">
    <h1>Hello {{Auth::user()->sex === 'm'? 'Sir.' : 'Madam.'}}</h1>
    <h2>{{ $period->name}} <br> {{$period->date_from }} to {{ $period->date_to }}</h2>
</div>
@include('welcome');
@endsection
