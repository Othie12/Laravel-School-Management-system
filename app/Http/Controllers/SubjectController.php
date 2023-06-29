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
        //
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        //
        return view('subject.create-subject', ['classes' => SchoolClass::all(), 'subjects' => Subject::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $subject = Subject::create([
            'name' => $request->name,
        ]);

        $classes = $request->input('classes', []);
        //$subject->classes()->attach($classes);
        foreach($classes as $class){
            $subjectClass = SubjectClass::create([
                'subject_id' => $subject->id,
                'class_id' => $class,
            ]);
        }

        return redirect()->back()->with('status', 'Subject saved successfully.');
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
    public function edit(string $id)
    {
        //
        return view('subject.edit', ['subject' => Subject::find($id), 'classes' => SchoolClass::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $subject = Subject::find($id);
        $subject->name = $request->name;
        $subject->save();

        return redirect()->back()->with('status', 'Updated successfuly');
    }

    public function updateClasses(Request $request, string $id)
    {
        $classes = $request->input('classes', []);
        $subject = Subject::find($id);

        $subject->classes()->sync($classes);
        return redirect()->back()->with('status', 'ClassList-updated-succesfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
