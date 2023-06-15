<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;

class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function resolve()
    {
        $schoolclass = SchoolClass::where('classteacher_id', Auth::user()->id)->first();
        $gradings = Grading::where('class_id', $schoolclass->id)->get();
        if (count($gradings) === 0) {
            return $this->create();
        }else{
            return $this->edit($gradings);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grading.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $schoolclass = SchoolClass::where('classteacher_id', Auth::user()->id)->first();
        $marks_from = array(0, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95);
        $marks_to = array(24, 29, 34, 39, 44, 49, 54, 59, 64, 69, 74, 79, 84, 89, 94, 100);
        $agg = $request->agg;
        $remarks = $request->remark;

        for ($i=0; $i < count($agg); $i++) {
            $stored = Grading::create([
                'class_id' => $schoolclass->id,
                'marks_from' => $marks_from[$i],
                'marks_to' => $marks_to[$i],
                'grade' => $agg[$i],
                'remark' => $remarks[$i],
            ]);
        }
        return redirect(route('grading'))->with('status', 'created Succesfully');
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
    public function edit($gradings)
    {
        return view('grading.update', ['gradings' => $gradings]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //first get the class to which this teacher is the classteacher
        $schoolclass = SchoolClass::where('classteacher_id', Auth::user()->id)->first();
        $gradings = Grading::where('class_id', $schoolclass->id)->get();
        $agg = $request->agg;
        $remarks = $request->remark;

        for ($i=0; $i < count($agg); $i++) {
            $gradings[$i]->grade = $agg[$i];
            $gradings[$i]->remark = $remarks[$i];
            $gradings[$i]->save();
        }
        return redirect(route('grading'))->with('status', 'updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
