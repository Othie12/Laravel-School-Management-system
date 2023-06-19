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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SchoolClass::all();
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        //$teachers = User::all();
        return view('class.create-class', ['teachers' => User::all(), 'classes' => SchoolClass::all()]);
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        //
        $schoolClass = SchoolClass::create([
            'name' => $request->name,
            'classteacher_id' => $request->classteacher,
        ]);
        return redirect()->back()->with('status', 'Class info saved successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schoolClass = SchoolClass::find($id);
        return view('class.details', ['class' => $schoolClass, 'periods' => Period::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $class = SchoolClass::find($id);
      return view('class.update-class', ['clas' => $class, 'teachers' => User::all()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::find($id);
        $schoolClass->name = $request->name;
        $schoolClass->classteacher_id = $request->classteacher;
        $schoolClass->save();

        return redirect()->back()->with('status', 'Updated successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SchoolClass::destroy([$id]);
    }
}
