<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoslClass;
use App\Models\Subject;
use App\Models\Marks;
use App\Models\Students;

class MarksController extends Controller
{
//insert new mark record if none has been recorded and update otherwise
    public function resolve2(Request $request){
        $subject_id = $request->subject_id;
        $stdnt_id = $request->student_id;
        $type = $request->type;
        $mark = $request->mark;
        $period = $request->period;

        $student = Students::find($stdnt_id);
        if($mid = $student->marks()->where('subject_id', $subject_id)->where('period_id', $period->id)->where('type', $type)->first()){
            $this->update($mid, $mark);
        }else{
            $this->store($stdnt_id, $subject_id, $period->id, $type = $type, $mark);
        }
    }
/*
    public function resolveStorage(Request $request)
    {
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;
        $students = $request->students;
        $marks_mid = $request->marks_mid;
        $marks_end = $request->marks_end;
        $period = $request->session()->get('period_id');

        $studentmksMid = array_combine($students, $marks_mid);
        $studentmksEnd = array_combine($students, $marks_end);

        foreach($studentmksMid as $stdnt_id => $mk){
            $student = Students::find($stdnt_id);
            if($mid = $student->marks()->where('subject_id', $subject_id)->where('period_id', session('period_id'))->where('type', 'mid')->first()){
                $this->update($mid, $mk);
            }else{
                $this->store($stdnt_id, $subject_id, $period, $type = 'mid', $mk);
            }
        }

        foreach($studentmksEnd as $stdnt_id => $mk){
            $student = Students::find($stdnt_id);
            if($end = $student->marks()->where('subject_id', $subject_id)->where('period_id', session('period_id'))->where('type', 'end')->first()){
               $this->update($end, $mk);
            }else{
               $this->store($stdnt_id, $subject_id, $period, $type = 'end', $mk);
            }
        }
    return redirect()->back()->with('status', 'updated succesfuly');
    }
*/

    public function specifiedMark(Request $request, string $student_id, string $subject_id, string $type)
    {
        $student = Students::find($student_id);
        $period = $request->period;
        $data = $student->marks()->where('subject_id', $subject_id)->where('period_id', $period->id)->where('type', $type)->first();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($stdnt_id, $subject_id, $period_id, $type, $mk)
    {
        //
        Marks::create([
            'student_id' => $stdnt_id,
            'subject_id' => $subject_id,
            'period_id'=> $period_id,
            'type' => $type,
            'mark' => $mk,
        ]);
    }

    public function show(string $id)
    {
        $mark = Mark::find($id);
        if($mark)
            return response()->json($mark, 200);
        return response()->json('Mark not found', 404);
    }

    public function update($mark, $mk)
    {
        $mark->mark = $mk;
        $mark->save();
    }
}
