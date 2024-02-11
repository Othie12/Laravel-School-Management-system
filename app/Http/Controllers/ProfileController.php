<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;


class ProfileController extends Controller
{
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if($request->has('name') && $request->name !== ''){
            $user->name = $request->name;
        }
        if($request->has('email') && $request->email !== ''){
            $user->email = $request->email;
        }
        if($request->has('role') && $request->role !== ''){
            $user->role = $request->role;
        }
        if($request->has('sex') && $request->sex !== ''){
            $user->sex = $request->sex;
        }
        if($request->has('contact') && $request->contact !== ''){
            $user->contact = $request->contact;
        }
        $user->save();
        return response()->json(['message' => 'Saved succesfuly'], 200);
    }

    public function updatePhoto(Request $request, string $id)
    {
        $user = User::find($id);
        $currentPhotoDirectory = $user->profile_pic_filepath;

        if ($currentPhotoDirectory) {
            Storage::delete($currentPhotoDirectory);
        }

        $newPhotoPath = $request->file('picture')->store('profile_pictures', 'public');

        $user->profile_pic_filepath = $newPhotoPath;
        $user->save();

        return redirect()->back()->with('status', 'Profile photo updated successfully!');
    }

    public function updatePassword(Request $request, string $id)
    {
        $user = User::find($id);
        if($request->has('newPassword') && $request->newPassword !== ''){
            if(!$request->has('oldPassword')){
                return response()->json(['error' => 'Old password is required'], 401);
            }
            $oldPassword = $request->oldPassword;
            $newPassword = $request->newPassword;
            if(!Auth::attempt(['email' => $user->email, 'password' => $oldPassword])){
                return response()->json(['error' => 'The old password is incorrect'], 401);
            }
            $user->password = Hash::make($newPassword);
        }

        $user->save();
        return response()->json(['message' => 'info-updated-successfully.', 200]);
    }

    public function updateSubjects(Request $request, string $id)
    {
        $subjects = $request->subjectIds;
        $user = User::find($id);

        $user->subjects()->sync($subjects);
        return response()->json(['message' => 'SubjectList-updated-succesfuly']);
    }

    public function updateClasses(Request $request, string $id)
    {
        $classes = $request->classIds;
        $user = User::find($id);

        $user->classes()->sync($classes);
        return response()->json(['message' => 'ClassList-updated-succesfuly']);
    }

}
