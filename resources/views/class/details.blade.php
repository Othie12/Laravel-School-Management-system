@extends('layouts.app')

@section('content')

<x-guest-layout>

    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs" style="display: flex; justify-content: space-between">
            <li><a href="#tab1" data-toggle="tab"><button type="button" class="btn btn-primary" style="background-color: deepskyblue"> Marksheet </button></a></li>
            <li><a href="#tab2" data-toggle="tab"><button type="button" class="btn btn-primary active" style="background-color: deepskyblue"> Students </button></a></li>
            <li><a href="#tab3" data-toggle="tab"><button type="button" class="btn btn-primary" style="background-color: deepskyblue"> Requirements </button></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="tab1">
                <table class="table table-hover table-stripes">
                    <thead>
                        <tr>
                            <th>Name</th>
                            @foreach ($class->subjects as $subject)
                                <th> {{ $subject->name }} </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class->students as $student)
                        <tr>
                            <td> {{$student->name}} </td>
                            @foreach ($class->subjects as $subject)
                            <?php $mark = $subject->marks()->where('student_id', $student->id)->where('type', 'end')->orderBy('created_at', 'desc')->first() ?>
                                <th class="{{ $mark ? '' : 'text-danger' }}"> {{  $mark ? $mark->mark  : 'Not set' }}  </th>
                            @endforeach
                            @if (Auth::user()->class === $student->class)
                                <td>
                                    <form action="{{ $student->already_promoted() ? route('student.demote', ['id' => $student->id]) : route('student.promote', ['id' => $student->id]) }}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button class="btn {{ $student->already_promoted() ? 'btn-danger' : 'btn-info' }}">{{  $student->already_promoted() ? 'Demote' : 'Promote'  }}</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-auth-session-status class="mb-4" :status="session('status')  " />

            </div>

            <div class="tab-pane active" id="tab2">
                <div class="row">
                @foreach ($class->students as $student)
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail col-12 col-md">
                    @if ($student->profile_pic_filepath)
                        <img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="100%" height="100%" class="rounded-md mr-2" style="border-radius: 5%">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" :width="__('100%')" />
                    @endif
                    </div>
                    <div class="caption">
                        <h3> {{ $student->name }} </h3>
                        <p></p>
                        <p>
                            <a href="{{ route('student.edit')}}?id={{$student->id }}" class="btn btn-primary" role="button">
                            Edit
                            </a>
                            <a href="{{ route('student.show', ['id' => $student->id]) }}" class="btn btn-default" role="button">
                            View
                            </a>
                            <div class="btn-group">
                                <button class="btn btn-danger">Report Card</button>
                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($student->periods() as $period)
                                    <li><a href="{{ route('reportcard', ['pid' => $period->id, 'sid' => $student->id])}}">{{ $period->name }} - {{ $period->value(DB::raw('YEAR(date_from)')) }} </a></li>

                                    @endforeach
                                </ul>
                            </div>
                        </p>
                    </div>
                </div>
                @endforeach
                </div>
            </div>


            <div class="tab-pane" id="tab3">
                <div class="row">
                <table class="table table-striped col-12">
                    <h4 align='center' class="text-info">Requirements</h4>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>quantity</th>
                        <th>price</th>
                        <th>Compulsary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $requirements = $class->requirements()->where('name', '!=', 'schoolfees')->where('period_id', session('period_id'))->get(); ?>
                    @if ($requirements && count($requirements) > 0 )
                        @foreach ($requirements as $item)
                        <tr>
                            <th>{{ $item->name }}</th>
                            <td>{{ $item->quantity === 0 ? '-' : $item->quantity }}</td>
                            <td>{{ $item->price  === null ? '-' : $item->price }}</td>
                            <td>{{ $item->compulsary === 'y' ? 'Yes' : 'No' }}</td>
                            <td><a href="{{ route('requirements.edit', ['id' => $item->id])}}"><i class="icon-edit"><button class="btn btn-info">Edit</button></i></a></td>
                            <td>
                                <form action="{{ route('requirements.delete', ['id' => $item->id]) }}" method="post" onsubmit=" !confirm('Are you sure?') ? event.preventDefault() : '' ">
                                    @csrf
                                    @method('delete')
                                    <i class="icon-edit"><button class="btn btn-danger">Delete</button></i>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <h4 align='center' class="text-error">No requirements yet</h4>
                    @endif
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

@endsection
