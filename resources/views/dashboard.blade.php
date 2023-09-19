@extends('layouts.app')
@section('content')

<div class="jumbotron" align="center">
    <h1>Hello {{Auth::user()->sex === 'm'? 'Sir.' : 'Madam.'}}</h1>
    @if ($period != null)
        <h2 class="text-info">{{ $period->name}} <br><span class="badge badge-info">{{ str_replace('-', '/', $period->date_from) }} to {{ str_replace('-', '/', $period->date_to) }}</span></h2>
    @endif
    <x-auth-session-status class="mb-4" :status="session('status')  " />
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

@if (in_array(Auth::user()->role, ['admini', 'head_teacher']))
    <div class="btn-group" align="left" style="position: sticky; top: 20%; z-index:1;">
        <button class="btn btn-danger">Set School Fees</button>
            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" style="z-index:1;">
                @foreach ($classes as $class)
                        <li><a href="{{ route('requirements.schoolfees', ['class_id' => $class->id])}}">{{ $class->name }}</a></li>
                @endforeach
            </ul>
    </div>
@endif
@include('welcome');
@endsection
