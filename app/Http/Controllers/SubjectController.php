<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\SubjectClass;
use App\Models\Subject;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class SubjectController extends Controller
{
    /**
     * Display a listing of subjects
     */

    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects, 200);
    }

    public function store(Request $request)
    {
        return response()->json($request, 200);

        $subject = Subject::create([
            'name' => $request->name,
        ]);

        if($request->has('classes') && $subject)
        {
            $classes = $request->classes;
            $classIds = [];
            foreach($classes as $class){
                array_push($classIds, $class['id']);
            }
            $subject->classes()->attach($classIds);
        }

        return $subject ? response()->json('Registered succesfuly', 200) : response()->json('Failed to register', 401);
    }

    public function show(string $id)
    {
        $subject = Subject::find($id)->load('classes');
        return $subject ? response()->json($subject, 200) : response()->json('Subject not found', 401);
    }

    public function update(Request $request, string $id)
    {
        $subject = Subject::find($id);
        if($subject){
            $subject->name = $request->name;
            $subject->save();
        }

        if($request->has('classes') && $subject)
        {
            $classes = $request->classes;
            $classIds = [];
            foreach($classes as $class){
                array_push($classIds, $class['id']);
            }
            $subject->classes()->sync($classIds);
        }

        return $subject ? response()->json('Updated succesfuly', 200) : response()->json('Id not found', 401);
    }

    public function destroy(string $id)
    {
        //
    }
}
