<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Period;
use App\Models\SchoolClass;
use App\Models\Students;
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

    public function getStudentsWithMarks(Request $request, string $id, string $type){
        $payload = [];
        $students = SchoolClass::find($id)->students()->get();
        foreach ($students as $student) {
            array_push(
                $payload,
                [
                    'student' => $student,
                    'markData' => $student->atomicMarkData($request->period, $type),
                ],
            );
        }
        return response()->json($payload, 200);
    }

    public function divisionMetrics(Request $request, string $id, string $type){
        $classItem = SchoolClass::find($id);
        $payload = [];
        $I = $II = $III = $IV = $U = 0;
        $students = $classItem->students;

        foreach ($students as $student) {
            $division = $student->atomicMarkData($request->period, $type)['division'];
            switch ($division) {
                case 'I':
                    $I++;
                    break;

                case 'II':
                    $II++;
                    break;

                case 'III':
                    $III++;
                    break;

                case 'IV':
                    $IV++;
                    break;

                default:
                    $U++;
                    break;
            }
        }

        $payload = [
            ['division' => 'I', 'count' => $I],
            ['division' => 'II', 'count' => $II],
            ['division' => 'III', 'count' => $III],
            ['division' => 'IV', 'count' => $IV],
            ['division' => 'U', 'count' => $U],
        ];

        return response()->json($payload, 200);
    }

    public function getGradingPerSubject(Request $request, string $id, string $type){
        $payload = SchoolClass::find($id)->gradesPerSubject($request->period->id, $type);
        return response()->json($payload, 200);
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

        if($request->has('fees_boarding')){
            $schoolClass->fees_boarding = $request->fees_boarding;
        }
        if($request->has('fees_day')){
            $schoolClass->fees_day = $request->fees_day;
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
