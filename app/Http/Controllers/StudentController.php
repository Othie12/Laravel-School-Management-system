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

    public function index(string $limit, string $offset)
    {
        $students = Students::limit($limit)->offset($offset)->orderBy('name')->get();
        return response()->json($students, 200);
    }

    public function search(string $term){
        $students = Students::where('name', 'like', "%$term%")->limit(10)->get();
        return response()->json($students, 200);
    }

    public function store(Request $request)
    {
        $student = Students::create([
            'name' => $request->name,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'class_id' => $request->class_id,
        ]);

        //if the parent id has been provided, save it to the database
        if($student && !empty($request->parent_id)){
            $student->parent_id = $request->parent_id;
            $student->save();
        }


        //first check if the student's picture has been provided
        if ($student && $request->hasFile('picture')) {
            //store the profilepicture into the profile_picures dir in public and return the name and path
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            // Save the profile picture file path to the database
            $student->profile_pic_filepath = $profilePicturePath;
            $student->save();
        }

        if($student){
            return response()->json('Saved successfuly', 200);
        }
        return response()->json('Failed to save student', 401);
    }

    public function show(string $id)
    {
        $student = Students::find($id)->load(['class', 'parent']);
        return $student ? response()->json($student, 200) : response()->json('Student not found', 401);
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

        if($student->save()){
            return response()->json('Updated succesfuly', 200);
        }
        return response()->json('Failed to update Student', 401);
    }

    public function updatePhoto(Request $request, string $id)
    {
        // Get the student
        $student = Students::find($id);

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
        return response()->json(['success' => 'Profile photo updated succesfully'], 200);
    }


    public function searchParent(Request $request){
        $searchterm = $request->term;
        $parents = User::where('name', 'like', "%$searchterm%")->where('role', 'parent')->get();
        return response()->json($parents);
    }

    public function promote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        $currentYear = Carbon::now()->year;
        if ($student->last_promoted && $year === $currentYear) {
            return response()->json(['error' => 'Student can not be promoted twice a year'], 422);
        }else if($student->class->next == null){
            return response()->json(['error' => 'Candidates can not be promoted'], 422);
        }else{
            $student->times_promoted++;
            $student->last_promoted = $currentYear;
            $student->class_id = $student->class->next()->id;
            $student->save();
            return response()->json(['success' => 'Promoted Succesfully'], 200);
        }
    }

    public function demote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        if ($student->times_promoted <= 0 && $student->last_promoted && $year === Carbon::now()->subYear()->year) {
            return response()->json(['error' => 'Can not demote twice a year Succesfully'], 422);
        }else{
            $student->times_promoted--;
            $student->last_promoted = Carbon::now()->subYear();
            $student->save();
            return response()->json(['success' => 'Demoted Succesfully'], 200);
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

    public function markData(Request $request, string $id){
        $data = Students::find($id)->markData($request->period);
        return response()->json($data, 200);
    }
}
