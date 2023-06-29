@extends('layouts.app')
    @section('content')
        <div align="center" class="mt-4 dark:bg-gray-700 items-center md:justify-center dark:text-gray-300">
            <a href="{{ 'storage/' . $student->profile_pic_filepath }}" align="center"><img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="100" class="rounded-md mr-2"></a>
        </div>
            <table class="table mt-4 dark:text-gray-300" style="background-image: url("{{ 'storage/' . $student->profile_pic_filepath }}");">
                <tr>
                    <th>Name: </th>
                    <td>{{ $student->name }}</td>
                </tr>
                <tr>
                    <th>Sex: </th>
                    <td>{{ $student->sex === 'm' ? 'Male' : 'Female' }}</td>
                </tr>
                <tr>
                    <th>D.O.B: </th>
                    <td>{{ $student->dob }}</td>
                </tr>
                <tr>
                    <th>Class: </th>
                    <td>{{ $student->class->name }}</td>
                </tr>
                <tr>
                    <th>
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
                    </th>
                </tr>
            </table>
    </section>
@endsection

@vite(['resources/css/app.css', 'resources/js/app.js'])
