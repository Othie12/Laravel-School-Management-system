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

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $class_id)
    {
        //
        $clas = Auth::user()->classes()->find($class_id);
        return view('marks.create', ['clas' => $clas, 'subjects' => Auth::user()->subjects, 'students' => $clas->students]);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($marks, $class_id)
    {
        //
        $clas = Auth::user()->classes()->find($class_id);
        return view('marks.show', ['clas' => $clas,  'subjects' => Auth::user()->subjects]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($mark, $mk)
    {
        $mark->mark = $mk;
        $mark->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
