<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parent.create', ['parents' => User::where('role', 'parent')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //first validate
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $parent = User::create([
            'name' => $request->parent_name,
            'email' => $request->parent_email,
            'sex' => $request->parent_sex,
            'contact' => $request->parent_contact,
            'password' => Hash::make("password"),
            'role' => 'parent',
        ]);

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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $parent = Parents::find($request->parent_id);
        $parent->name = $request->parent_name;
        $parent->email = $request->parent_email;
        $parent->sex = $request->parent_sex;
        $parent->contact = $request->parent_contact;
        $parent->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
