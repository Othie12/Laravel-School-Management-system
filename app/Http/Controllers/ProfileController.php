<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function editOther(Request $request): View
    {
        $teacher = User::find($request->user_id);
        return view('profile.edit', [
            'user' => $teacher,
            'teacherSubjects' => $teacher->subjects,
            'subjects' => Subject::all(),
            'teacherClasses' => $teacher->classes,
            'classes' => SchoolClass::all(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->contact = $request->contact;
        $request->user()->sex = $request->sex;
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateOther(Request $request){
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->sex = $request->sex;
        $user->contact = $request->contact;
        $user->save();
        return redirect()->back()->with('status', 'info-updated-successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }

    public function destroyOther(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = User::find($request->user_id);

        $user->delete();

        return Redirect::to('/dashboard')->with('status', 'deleted successfuly.');
    }


    public function updateSubjects(Request $request)
    {
        $subjects = $request->input('subjects', []);
        $user = User::find($request->user_id);

        $user->subjects()->sync($subjects);
        return redirect()->back()->with('status', 'SubjectList-updated-succesfuly');
    }

    public function updateClasses(Request $request)
    {
        $classes = $request->input('classes', []);
        $user = User::find($request->user_id);

        $user->classes()->sync($classes);
        return redirect()->back()->with('status', 'ClassList-updated-succesfuly');
    }

}
