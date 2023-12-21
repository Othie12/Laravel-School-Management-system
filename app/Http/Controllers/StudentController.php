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
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StudentController extends Controller
{

    public function index($classId)
    {
        $class = SchoolClass::find($classId);
        return view('student.showall',[ 'students' => $class->Students]);
    }

    public function create()
    {
        return view('student.create', ['classes' => SchoolClass::all(), 'parents' => User::where('role', 'parent')->get()]);
    }

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

    public function show(string $id)
    {
        return view('student.show', ['student' => Students::find($id)]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        return view('student.update', ['student' => Students::find($id), 'classes' => SchoolClass::all(),  'parents' => User::where('role', 'parent')->get()]);
    }

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

    public function updatePhoto(Request $request)
    {
        // Get the student
        $student = Students::find($request->id);

        // Retrieve the student's current profile photo directory from the database
        $currentPhotoDirectory = $student->profile_pic_filepath;

        // Delete the current photo from the filesystem
        if ($currentPhotoDirectory) {
            Storage::delete($currentPhotoDirectory);
        }

        // Upload the new photo
        $newPhotoPath = $request->file('picture')->store('profile_pictures', 'public');

        // Update the student's profile photo with the new photo
        $student->profile_pic_filepath = $newPhotoPath;
        $student->save();

        return redirect()->back()->with('status', 'Profile photo updated successfully!');
    }


    public function searchParent(Request $request){
        $searchterm = $request->term;
        $parents = User::where('name', 'like', "%$searchterm%")->where('role', 'parent')->get();
        return response()->json($parents);
    }

    public function promote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        if ($student->last_promoted && $year === Carbon::now()->year) {
            return redirect()->back()->with('status', 'Cannot promote twice a year');
        }else{
            $student = Students::find($id);
            $student->times_promoted++;
            $student->last_promoted = Carbon::now();
            $student->save();
            return redirect()->back()->with('status', 'Promoted succesfuly');
        }
    }

    public function demote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        if ($student->times_promoted <= 0 && $student->last_promoted && $year === Carbon::now()->subYear()->year) {
            return redirect()->back()->with('status', 'Can only demote once a year');
        }else{
            $student->times_promoted--;
            $student->last_promoted = Carbon::now()->subYear();
            $student->save();
            return redirect()->back()->with('status', 'Demoted succesfuly');
        }
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        $request->validateWithBag('studentDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        //
        $student = Students::find($id);
        $student->delete();
        return Redirect::to(route('dashboard'));
    }

    public function markData(string $id){
        $data = Students::find($id)->markData();
        return response()->json($data, 200);
    }
}
