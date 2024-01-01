<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class GradingController extends Controller
{
    public function index($classId){
        $gradings = Grading::where('class_id', $classId)->get();
        return response()->json($gradings, 200);
    }

    public function store(string $classId, Request $request)
    {
            $stored = Grading::create([
                'class_id' => $classId,
                'marks_from' => $request->marks_from,
                'marks_to' => $request->marks_to,
                'grade' => $request->grade,
                'remark' => $request->remark,
            ]);
            return response()->json($stored, 200);
    }

    public function update(Request $request, string $id)
    {
        $grading = Grading::find($id);

        $grading->marks_from = $request->marks_from;
        $grading->marks_to = $request->marks_to;
        $grading->grade = $request->grade;
        $grading->remark = $request->remark;
        $grading->save();

        return response()->json($grading, 200);
    }

    public function destroy(string $id)
    {
        Grading::destroy($id);
        return response()->json(['message' => 'deleted succesfuly'], 200);
    }

    public function buildGrade($grade){
        switch ($grade) {
                        case 1:
                            return 'D1';
                            break;

                        case 2:
                            return 'D2';
                            break;

                        case 3:
                            return 'C3';
                            break;

                        case 4:
                            return 'C4';
                            break;

                        case 5:
                            return 'C5';
                            break;

                        case 6:
                            return 'C6';
                            break;

                        case 7:
                            return 'P7';
                            break;

                        case 8:
                            return 'P8';
                            break;

                        case 9:
                            return 'F9';
                            break;

                        default:
                            return 'Unresolved';
                            break;
                    }
    }
}
