<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GradingController extends Controller
{
    public function index($classId){
        $gradings = Grading::where('class_id', $classId)->get();
        return response()->json($gradings, 200);
    }

    public function store(string $classId, Request $request)
    {
        $stored = Grading::create([
            'class_id' => $classId,
            'marks_from' => $request->marks_from,
            'marks_to' => $request->marks_to,
            'grade' => $request->grade,
            'remark' => $request->remark,
        ]);
        return $stored ? response()->json($stored, 200) : response()->json(['error' => 'Failed to store resource'], 500);
    }

    public function createViaExcel(Request $request, string $class_id){
        if(!$request->hasFile('excelfile')){
            return response()->json(['message' => 'No excelfile detected'], 400);
        }
        $excelFile = $request->file('excelfile');
        $spreadsheet = IOFactory::load($excelFile);

        $startIndex = 0;
        $successful = 0;
        $uploaded = 0;
        $invalidAgg = 0;

        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        if(count($rows[0]) < 4){
            return response()->json(
                ['message' => 'Some columns are missing, we expect FROM, TO, AGGREGATE, REMARK rows in your submission']
                , 400);
        }

       //first get the row starting with 'NAME' cell, we'll start reading the
        //excelfile from here
        foreach ($rows as $index => $row) {
            if(strtoupper($row[0]) == 'FROM'){
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

            $from = $row[0];
            $to = $row[1];
            $agg = $row[2];
            $remark = $row[3];
            if($agg < 1 || $agg > 9) {$invalidAgg++; continue;}
            //if(!(is_int($from) && is_int($to))) continue;

            if($g = Grading::where('class_id', $class_id)->where('marks_from', $from)->where('marks_to', $to)->first()){
                $g->agg = $agg;
                $g->remark  = $remark;
                if($g->save()) $successful++;
                continue;
            }

            $stored = Grading::create([
                'class_id' => $class_id,
                'marks_from' => $from,
                'marks_to' => $to,
                'grade' => $agg,
                'remark' => $remark,
            ]);
            if($stored) $successful++;
        }
        $result = ['succesful' => $successful,
                    'uploaded' => $uploaded,
                    'failed' => $uploaded - $successful,
                    'invalid_agg' => $invalidAgg,
                ];
        return response()->json($result, 200);
    }

    public function update(Request $request, string $id)
    {
        $grading = Grading::find($id);

        $grading->marks_from = $request->marks_from;
        $grading->marks_to = $request->marks_to;
        $grading->grade = $request->grade;
        $grading->remark = $request->remark;
        $grading->save();

        return response()->json($grading, 200);
    }

    public function destroy(string $id)
    {
        Grading::destroy($id);
        return response()->json(['message' => 'deleted succesfuly'], 200);
    }

    public function buildGrade($grade){
        switch ($grade) {
                        case 1:
                            return 'D1';
                            break;

                        case 2:
                            return 'D2';
                            break;

                        case 3:
                            return 'C3';
                            break;

                        case 4:
                            return 'C4';
                            break;

                        case 5:
                            return 'C5';
                            break;

                        case 6:
                            return 'C6';
                            break;

                        case 7:
                            return 'P7';
                            break;

                        case 8:
                            return 'P8';
                            break;

                        case 9:
                            return 'F9';
                            break;

                        default:
                            return 'Unresolved';
                            break;
                    }
    }
}
