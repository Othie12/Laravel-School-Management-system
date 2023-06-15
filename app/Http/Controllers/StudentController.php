<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Parents;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($classId)
    {
        $class = SchoolClass::find($classId);
        return view('student.showall',[ 'students' => $class->Students]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('student.create', ['classes' => SchoolClass::all(), 'parents' => User::where('role', 'parent')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //create a new student record in the database
        $student = Students::create([
            'name' => $request->name,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'class_id' => $request->class,
        ]);

        //if the parent id has been provided, save it to the database
        if(!empty($request->parent)){
            $student->parent_id = $request->parent;
            $student->save();
        }


        //first check if the student's picture has been provided
        if ($request->hasFile('picture')) {
            //store the profilepicture into the profile_picures dir in public and return the name and path
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            // Save the profile picture file path to the database
            $student->profile_pic_filepath = $profilePicturePath;
            $student->save();
        }

        return redirect()->back()->with('status', 'Student saved successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Students::find($id);
        return view('student.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(string $id = '1')
    {
        //
        return view('student.update', ['student' => Students::find($id), 'classes' => SchoolClass::all(),  'parents' => User::where('role', 'parent')->get()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $student = Students::find($id);
        $student->name = $request->name;
        $student->sex = $request->sex;
        $student->dob = $request->dob;
        $student->parent_id = $request->parent;
        $student->class_id = $request->class_id;
        $student->save();

        return redirect()->back()->with('status', 'Student updated successfully');

    }

    /**
     * Get the desired parent from the database
     */
    public function searchParent(Request $request){
        $searchterm = $request->term;
        $parents = User::where('name', 'like', "%$searchterm%")->where('role', 'parent')->get();
        return response()->json($parents);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $request->validateWithBag('studentDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        //
        $student = Students::find($id);
        $student->delete();
        return Redirect::to('/');

    }
}
