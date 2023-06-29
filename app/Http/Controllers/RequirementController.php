<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Requirements;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($class_id)
    {
        //
        return view('requirements.show', ['requirements' => Requirements::where('class_id', $class_id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('requirements.create', ['classes' => SchoolClass::all()]);
    }

    public function schoolfees(Request $request, $class_id)
    {
        return view('requirements.schoolfees', ['classes' => SchoolClass::all(), 'item' => Requirements::where('class_id', $class_id)
        ->where('period_id', $request->session()->get('period_id'))->where('name', 'schoolfees')->first(), 'class' => SchoolClass::find($class_id)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $req = Requirements::where('name', $request->name)->where('class_id', $request->class_id)->where('period_id', $request->session()->get('period_id'))->first();
        if ($req === null) {
            $requirement = Requirements::create([
                'class_id' => $request->class_id,
                'period_id' =>$period = $request->session()->get('period_id'),
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'compulsary' => $request->compulsary,
            ]);
            return redirect()->back()->with('status', 'created succesfuly');
        }else {
            return redirect()->back()->with('status', 'This record has already been set, you can only update it now');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return view('requirements.edit', ['classes' => SchoolClass::all(), 'req' => Requirements::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $requirement = Requirements::find($id);
        $requirement->class_id = $request->class_id;
        $requirement->name = $request->name;
        $requirement->quantity = $request->quantity;
        $requirement->price = $request->price;
        $requirement->compulsary = $request->compulsary;
        $requirement->save();
        return redirect()->back()->with('status', 'updated succesfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $requirement = Requirements::find($id);
        $class_id = $requirement->class_id;
        $requirement->delete();
        return redirect(route('class-show', ['id' => $class_id]))->with('status', 'Record Deleted');
    }
}
