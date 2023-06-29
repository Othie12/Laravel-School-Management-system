@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" align='center'>
        <h1>ABCD NUR &amp PRI SCHOOL</h1>
        <p>Seeta, Mukono Uganda<br>Tel: 0703892783, 0755473844 <br> <b>TERMINAL REPORT</b> </p>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <img src="{{ asset('storage/' . $student->profile_pic_filepath) }}" alt="Profile Image" width="100" height="100" class="rounded-md mr-2" style="border-radius: 5%">
    </div>
</div>
<div class="row">
        <table class="table">
            <tr>
                <th> <b>PUPIL'S NAME:</b> <span style="color:red" >{{ $student->name }}</span> </th>
                <th>CLASS: <span style="color:red">{{ $student->class->name }}</span> </th>
                <th>{{ $period->name }} - {{ $period->value(DB::raw('YEAR(date_from)')) }}</th>
            </tr>
        </table>
        @if (count($student->marks()->where('period_id', $period->id)->get()) > 0)
        <table class="table table-hover">
            <tr>

                <th>SUBJECT</th>
                <th>AGGREGATES</th>
                <th>REMARKS</th>
                <th>TEACHER</th>
            </tr>
            <?php
            $totalAgg = 0;//Gonna use it to get the total aggregate mark in all subjects
            $totalMarks = 0;//Gonna use it to get the total marks in all subjects
            $count = 0;//gonna use it to get the total number of subjects which i'll later use to get the optimal overal mark
            ?>
            @foreach ($student->class->subjects as $subject)
            <?php
                $markMid = $subject->marks->where('student_id', $student->id)->where('period_id', $period->id)->where('type', 'mid')->first();
                $markEnd = $subject->marks->where('student_id', $student->id)->where('period_id', $period->id)->where('type', 'end')->first();
                $gradeMid = $markMid->grading() ? $markMid->grading()->grade : 9;
                $gradeEnd = $markEnd->grading() ? $markEnd->grading()->grade : 9;
                $agg = ($gradeMid + $gradeEnd) / 2;
                $mm = $markMid ? $markMid->mark : 0;
                $me = $markEnd ? $markEnd->mark : 0;
                $mark = ($mm > 0 && $me > 0) ? ($mm + $me) / 2 : 0;
                $totalMarks += $mark;
                $count++;
            ?>
            <tr>
                <th>{{ $subject->name }}</th>
                <td>{{ $agg }}</td>
                <td>{{ $markEnd->grading() ? $markEnd->grading()->remark : 'N/A'}}</td>
                <td>{{ $subject->teachers->first()->name ? $subject->teachers->first()->name : 'N/A'}} </td>
                <td>{{ $mark  }}</td>
                <?php $totalAgg += $agg  ?>
            </tr>
            @endforeach

            <tr>
                <th>Total</th>
                <th>{{ $totalAgg }}</th>
            </tr>


        </table>

        <?php
            $optimalMarks = $count * 100;//get the optimal marks for all the subjects the student does ie each subj has 100.
            $percentage = ($totalMarks / $optimalMarks) * 100;//get the percentile to which the student falls in the overal exams.
            //get the comment that falls in the student's percentile
            $comment = $student->class->comments->where('agg_from', '<=', $percentage)->where('agg_to', '>=', $percentage)->first();
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <p><b>Headteacher's comment: </b>{{ $comment->ht_comm ? $comment->ht_comm  : 'Not yet set' }}</p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <p><b>Classteacher's comment: </b>{{ $comment->ct_comm ? $comment->ct_comm  : 'Not yet set' }}</p>
        </div>

            <table class="table">
                <tr>
                    <th>Next term begins on: <u>23 / 02 / 2023</u></th>
                    <th>SchoolFees: <span style="color:red">Shs.{{ $student->class->requirements->where('name', 'schoolfees')->where('period_id', $period->id)->first() ? $student->class->requirements->where('name', 'schoolfees')->where('period_id', $period->id)->first()->price : 'Not set' }}</span></th>
                </tr>
            </table>
            <table class="table table-striped">
                <h4 align='center' class="text-info">Other requirements</h4>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>quantity</th>
                    <th>price</th>
                </tr>
            </thead>
            <tbody>
                <?php $requirements = $student->class->requirements()->where('name', '!=', 'schoolfees')->where('period_id', $period->id)->get(); ?>
                @if (count($requirements) > 0 )
                    @foreach ($requirements as $item)
                    <tr>
                        <th>{{$item->name}}</th>
                        <td>{{ $item->quantity === 0 ? '-' : $item->quantity}} </td>
                        <td>{{ $item->price  === null ? '-' : $item->price }}</td>
                    </tr>
                    @endforeach
                @else
                    <h4 align='center' class="text-error">No requirements yet</h4>
                @endif
            </tbody>
            </table>
            @else
            <h2 class="text-error">This student has no marks for this term</h2>
            @endif
</div>

@endsection
