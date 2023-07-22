<?php

namespace App\Http\Controllers\Auth;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
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

        if($request->has('subjects'))
        {
            $subjects = $request->input('subjects', []);
            foreach($subjects as $subject){
                $subjectTeacher = SubjectTeacher::create([
                    'subject_id' => $subject,
                    'teacher_id' => $user->id,
                ]);//Staff member
            }
        }

        if($request->has('classes'))
        {
            $classes = $request->input('classes', []);
            $user->classes()->attach($classes);
        }


        if ($request->hasFile('picture')) {
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            // Save the profile picture file path to the database
            $user->profile_pic_filepath = $profilePicturePath;
            $user->save();
        }


        //event(new Registered($user));

        //Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        return redirect()->back()->with('status', 'Created successfully.');

    }
}
