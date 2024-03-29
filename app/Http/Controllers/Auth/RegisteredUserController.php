<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\SubjectTeacher;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', ['subjects' => Subject::all(), 'classes' => SchoolClass::all(), 'teachers' => User::where('role', '!=', 'parent')->get()]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|string',
            'sex' => 'required|string',
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);//Staff member

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make("password"),
            'role' => $request->role,
            'sex' => $request->sex,
            'contact' => $request->contact,
        ]);

        if($request->has('subjects') && $user)
        {
            $subjects = $request->subjects;
            $subjectIds;
            foreach($subjects as $subject){
                array_push($subjectIds, $subject['id']);
            }
            $user->subjects()->attach($subjectIds);
        }

        if($request->has('classes') && $user)
        {
            $classes = $request->classes;
            $classIds;
            foreach($classes as $class){
                array_push($classes, $class['id']);
            }
            $user->classes()->attach($classIds);
        }


        if ($request->hasFile('picture') && $user) {
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            // Save the profile picture file path to the database
            $user->profile_pic_filepath = $profilePicturePath;
            $user->save();
        }


        //event(new Registered($user));

        //Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        return $user ? response()->json('Registered succesfuly', 200) : response()->json('Failed to regiter user', 401);

    }
}
