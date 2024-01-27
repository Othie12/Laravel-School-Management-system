<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Requirements;

class RequirementController extends Controller
{
    public function index()
    {
        $requirements = Requirements::all();
        return response()->json($requirements, 200);
    }

    public function schoolFees(Request $request, $class_id)
    {
        $item = Requirements::where('class_id', $class_id)->where('period_id', $request->period()->id)->where('name', 'schoolfees')->first();
        return response()->json($item, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req = Requirements::where('name', $request->name)->where('class_id', $request->class_id)->where('period_id', $request->period()->id)->first();
        if ($req === null) {
            $requirement = Requirements::create([
                'class_id' => $request->class_id,
                'period_id' =>$period = $request->period()->id,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->has('price') ? $request->price : '',
                'compulsary' => $request->compulsary,
            ]);
            return response()->json('Created succesfuly', 200);
        }else {
            return response()->json('Item already regisered', 401);
        }
    }

    public function update(Request $request, string $id)
    {
        $requirement = Requirements::find($id);
        if($requirement){
            if($request->has('class_id')){
                $requirement->class_id = $request->class_id;
            }
            if($request->has('name')){
                $requirement->name = $request->name;
            }
            if($request->has('quantity')){
                $requirement->quantity = $request->quantity;
            }
            if($request->has('price')){
                $requirement->price = $request->price;
            }
            if($request->has('compulsary')){
                $requirement->compulsary = $request->compulsary;
            }
            $requirement->save();
            return response()->json('Updated succesfuly', 200);
        }
        return response()->json('No item with this Id', 401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $requirement = Requirements::find($id);
        $class_id = $requirement->class_id;
        $requirement->delete();
        return response()->json('Deleted succesfuly', 200);
    }
}
