<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(string $classId)
    {
        $items = [];
        $today = Carbon::now()->startOfDay();
        $students = SchoolClass::find($classId)->students;
        foreach ($students as $student) {
            if($student->attendance()->where('date', $today)->first() !== null){
                array_push($items, ['id' => $student->id, 'name' => $student->name, 'attended' => true]);
            }else{
                array_push($items, ['id' => $student->id, 'name' => $student->name, 'attended' => false]);
            }
        }
        return response()->json($items, 200);
    }

    public function store(Request $request)
    {
        $student_ids = [];

        foreach($request->attendanceData as $item){
            if($item['attended']){
                array_push($student_ids, $item['id']);
            }
        }

        //first remove any student that's not checked this time.
        $records = Attendance::where('date', Carbon::now()->startOfDay())->get();
        foreach ($records as $record) {
            if(!in_array($record->student_id, $student_ids)){
                Attendance::destroy($record->id);
            }
        }
        //record attendance for any student who's been checked once
        foreach ($student_ids as $student_id) {
            $recorded = Attendance::where('date', Carbon::now()->startOfDay())->where('student_id', $student_id)->first();
            if($recorded === null){
                Attendance::create([
                    'student_id' => $student_id,
                    'date' => now(),
                ]);
            }
        }
        return response()->json(['message' => 'Recorded succesfuly'], 200);
    }

    public function show(string $id, string $class_id)
    {
        //
    }
}
