<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Requirements;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RequirementController extends Controller
{
    public function index()
    {
        $requirements = Requirements::all();
        return response()->json($requirements, 200);
    }

    public function schoolFees(Request $request, $class_id){
        $item = Requirements::where('class_id', $class_id)->where('period_id', $request->period()->id)->where('name', 'schoolfees')->first();
        return response()->json($item, 200);
    }

    public function createViaExcel(Request $request, string $class_id){
        $period = $request->period;
        if(!$period){
            return response()->json(['message' => 'Sorry you can not create requirements in holiday'], 400);
        }

        if(!$request->hasFile('excelfile')){
            return response()->json(['message' => 'No excelfile detected'], 400);
        }
        $excelFile = $request->file('excelfile');
        $spreadsheet = IOFactory::load($excelFile);

        $startIndex = 0;
        $successful = 0;
        $uploaded = 0;

        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        if(count($rows[0]) < 2){
            return response()->json(
                ['message' => 'Some columns are missing, we expect NAME, QUANTITY rows in your submission']
                , 400);
        }

       //first get the row starting with 'NAME' cell, we'll start reading the
        //excelfile from here
        foreach ($rows as $index => $row) {
            if(strtoupper($row[0]) == 'NAME'){
                $startIndex = $index + 1;
                break;
            }else if($index == count($rows) - 1){
                return response()->json(
                    ['message' => 'We did not find any row starting with the FROM cell, Please make sure their
                    is a column starting with the heading FROM. That is where the code starts reading']
                    , 400);
            }
        }

        for($i = $startIndex; $i < count($rows); $i++){
            $row = $rows[$i];

            $uploaded++;

            $name = $row[0];
            $quantity = $row[1];

            if($req = Requirements::where('name', $request->name)->where('class_id', $request->class_id)->where('period_id', $period->id)->first()){
                continue;
            }

            $stored = Requirements::create([
                'class_id' => $class_id,
                'period_id' => $period->id,
                'name' => $name,
                'quantity' => $quantity,
                'price' => 0,
                'compulsary' => 'Yes',
            ]);
            if($stored) $successful++;
        }
        $result = ['succesful' => $successful,
                    'uploaded' => $uploaded,
                    'failed' => $uploaded - $successful,
                ];
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $period = $request->period;
        if(!$period){
            return response()->json(['message' => 'Sorry you can not create requirements in holiday'], 400);
        }

        $req = Requirements::where('name', $request->name)->where('class_id', $request->class_id)->where('period_id', $period->id)->first();
        if ($req === null) {
            $requirement = Requirements::create([
                'class_id' => $request->class_id,
                'period_id' => $period->id,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'price' => $request->has('price') ? $request->price : 0,
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
