<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ParentController extends Controller
{
    public function index(string $limit, string $offset)
    {
        $parents = User::where('role', 'parent')->limit($limit)->offset($offset)->orderBy('name')->get();
        return response()->json($parents, 200);
    }

    public function search(string $term){
        $parents = User::where('role', 'parent')->where('name', 'like', '%'.$term.'%')->get();
        return response()->json($parents, 200);
    }

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

        if($parent){
            return response()->json($parent, 200);
        }
        return response()->json(['error' => 'Failed to save parent'], 401);
    }

    public function show(string $id)
    {
        $parent = User::find($id);
        if($parent){
            return response()->json($parent, 200);
        }
        return response()->json(['error' => 'No parent with this id'], 404);
    }


    public function update(Request $request, string $id)
    {
        $parent = Parents::find($id);
        $parent->name = $request->parent_name;
        $parent->email = $request->parent_email;
        $parent->sex = $request->parent_sex;
        $parent->contact = $request->parent_contact;
        if($parent->save()){
            return response()->json($parent, 200);
        }
        return response()->json(['error' => 'Failed to save parent'], 401);
    }
}
