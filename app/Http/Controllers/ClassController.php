<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Period;
use App\Models\SchoolClass;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class ClassController extends Controller
{

    public function index()
    {
        $classes = SchoolClass::all()->load('classTeacher');
        return response()->json($classes, 200);
    }

    public function getStudents(string $id){
        $students = SchoolClass::find($id)->students()->get();
        return response()->json($students, 200);
    }

    public function getRequirements(Request $request, string $id){
        $requirements = SchoolClass::find($id)->requirements()->where('period_id', $request->period->id)->get();
        return response()->json($requirements, 200);
    }

    public function store(Request $request)
    {
        $schoolClass = SchoolClass::create([
            'name' => $request->name,
            'classteacher_id' => $request->classteacher_id,
        ]);
        return response()->json($schoolClass, 200);
    }

    public function show(string $id)
    {
        $schoolClass = SchoolClass::with(['classTeacher', 'subjects', 'gradings', 'requirements', 'students'])->find($id);
        return response()->json($schoolClass, 200);
        return view('class.details', ['class' => $schoolClass, 'periods' => Period::all()]);
    }

    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::find($id);

        if($request->has('fees')){
            $schoolClass->fees = $request->fees;
        }

        if($request->has('classteacher_id')){
            $schoolClass->classteacher_id = $request->classteacher_id;
        }
        $schoolClass->save();

        return response()->json($schoolClass, 200);
    }

    public function destroy(string $id)
    {
        SchoolClass::destroy([$id]);
        return response()->json(['updated succesfully'], 200);
    }
}
