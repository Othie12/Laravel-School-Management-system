@extends('layouts.app')

@section('content')


    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs" style="display: flex; justify-content: space-between">
            <li><a href="#tab1" data-toggle="tab"><button type="button" class="btn btn-primary active" style="background-color: deepskyblue"> Marksheet </button></a></li>
            <li><a href="#tab2" data-toggle="tab"><button type="button" class="btn btn-primary" style="background-color: deepskyblue"> Students </button></a></li>
            <li><a href="#tab3" data-toggle="tab"><button type="button" class="btn btn-primary" style="background-color: deepskyblue"> Other requirements </button></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
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
                                <th> {{ $subject->marks()->where('student_id', $student->id)->where('type', 'end')->orderBy('created_at', 'desc')->first() ? $subject->marks()->where('student_id', $student->id)->where('type', 'end')->orderBy('created_at', 'desc')->first()->mark  : 'Not set' }}  </th>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="tab2">
                <div class="row">
                @foreach ($class->students as $student)
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                    @if ($student->value('profile_pic_filepath'))
                        <img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="100" height="100" class="rounded-md mr-2" style="border-radius: 5%">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    @endif
                    </div>
                    <div class="caption">
                        <h3> {{ $student->name }} </h3>
                        <p></p>
                        <p>
                            <a href="{{route('student.edit')}}?id={{$student->id}}" class="btn btn-primary" role="button">
                            Edit
                            </a>
                            <a href="#" class="btn btn-default" role="button">
                            View
                            </a>
                            <div class="btn-group">
                                <button class="btn btn-danger">Report Card</button>
                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($periods as $period)
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
        </div>
    </div>


@endsection
