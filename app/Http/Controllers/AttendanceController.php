<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\SchoolClass;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        //
    }

    public function create(string $class_id)
    {
        return view('attendance.create', ['class' => SchoolClass::find($class_id), 'tday' => Carbon::now()->startOfDay()]);
    }

    public function store(Request $request)
    {
        //first remove any student that's not checked this time.
        $records = Attendance::where('date', Carbon::now()->startOfDay())->get();
        foreach ($records as $record) {
            if(!in_array($record->student_id, $request->student_ids)){
                Attendance::destroy($record->id);
            }
        }
        //record attendance for any student who's been checked once
        foreach ($request->student_ids as $student_id) {
            $recorded = Attendance::where('date', Carbon::now()->startOfDay())->where('student_id', $student_id)->first();
            if($recorded === null){
                Attendance::create([
                    'student_id' => $student_id,
                    'date' => now(),
                ]);
            }
        }
        return back()->with('status', 'Recorded succesfuly');
    }

    public function show(string $id, string $class_id)
    {
        //
    }
}
