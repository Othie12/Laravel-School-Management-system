@extends('layouts.app')



@section('content')

<div class="jumbotron" align="center">
    <h1>Hello {{Auth::user()->sex === 'm'? 'Sir.' : 'Madam.'}}</h1>
    <h2>{{ $period->name}} <br> {{$period->date_from }} to {{ $period->date_to }}</h2>
</div>

@if (Auth::user()->role === 'head_teacher')
<div class="btn-group" align="left" style="position: sticky; top: 20%; z-index:1;">
    <button class="btn btn-danger">Set Headteacher's comments here</button>
        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" style="z-index:1;">
            @foreach ($classes as $class)
                @if (count($class->comments) > 0)
                    <li><a href="{{ route('comments.edit', ['class_id' => $class->id])}}">{{ $class->name }}</a></li>
                @endif
            @endforeach
        </ul>
</div>
@endif

@include('welcome');
@endsection
