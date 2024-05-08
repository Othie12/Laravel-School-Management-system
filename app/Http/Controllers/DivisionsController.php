<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\Division;
use App\Models\SchoolClass;

class DivisionsController extends Controller
{
    public function index($classId){
        $divisions = Division::where('class_id', $classId)->get();
        return response()->json($divisions, 200);
    }

    public function store(string $classId, Request $request)
    {
            $stored = Division::create([
                'class_id' => $classId,
                'aggs_from' => $request->aggs_from,
                'aggs_to' => $request->aggs_to,
                'division' => $request->division,
            ]);
                return $stored ? response()->json($stored, 200) : response()->json(['error' => 'Failed to store resource'], 500);
    }

    public function update(Request $request, string $id)
    {
        $division = Division::find($id);

        $division->aggs_from = $request->aggs_from;
        $division->aggs_to = $request->aggs_to;
        $division->division = $request->division;
        $division->save();

        return response()->json($division, 200);
    }

    public function destroy(string $id)
    {
        Division::destroy($id);
        return response()->json(['message' => 'deleted succesfuly'], 200);
    }

}
