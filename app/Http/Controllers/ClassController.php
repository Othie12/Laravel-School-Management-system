<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Period;
use App\Models\SchoolClass;
use App\Models\Students;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;


class ClassController extends Controller
{

    public function index()
    {
        $classes = SchoolClass::all()->load('classTeacher');
        return response()->json($classes, 200);
    }

    public function registerClassStudentsViaExcel(Request $request, string $class_id){
        if(!$request->hasFile('excelfile'))
            return response()->json(['message' => 'No excelfile detected'], 400);

        $excelFile = $request->file('excelfile');
        $spreadsheet = IOFactory::load($excelFile);

        //row to start reading excel-file
        $startIndex = 0;

        $successful = 0;
        $uploaded = 0;
        $duplicate = 0;
        $invalidSection = 0;
        $invalidSex = 0;


        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        //first get the row starting with 'NAME' cell, we'll start reading the
        //excelfile from here
        foreach ($rows as $index => $row) {
            if(strtoupper($row[0]) == 'NAME'){
                $startIndex = $index + 1;
                break;
            }else if($index == count($rows) - 1){
                return response()->json(
                    ['message' => 'We did not find any row starting with the NAME cell, Please make sure their
                    is a column starting with the heading NAME. That is where the code starts reading']
                    , 400);
            }
        }

        for($i = $startIndex; $i < count($rows); $i++){
            $row = $rows[$i];

            $uploaded++;

            $name = $row[0];
            $sex = $row[1] ? strtolower($row[1]) : 'm';
            $section = $row[2] ? $row[2] : 'Day';

            if(strtoupper($section) === 'BOARDING') $section = 'Boarding';
            if(strtoupper($section) === 'DAY') $section = 'Day';

            if(!($sex === 'm' || $sex === 'f')) {$invalidSex++; continue;}
            if(!($section !== 'Boarding' || $section !== 'Day')) {$invalidSection++; continue;}
            if($student = Students::where('name', $name)->first()){$duplicate++;continue;}

            $student = Students::create([
                'name' => $name,
                'sex' => $sex,
                'section' => $section,
                'class_id' => $class_id,
            ]);
            if($student) $successful++;
        }
        $result = ['succesful' => $successful,
                    'uploaded' => $uploaded,
                    'failed' => $uploaded - $successful,
                    'duplicates' => $duplicate,
                    'invalid_section' => $invalidSection,
                    'invalid_sex' => $invalidSex,
                ];
        return response()->json($result, 200);
    }

    public function getStudents(string $id){
        $students = SchoolClass::find($id)->students()->get();
        return response()->json($students, 200);
    }

    public function getStudentsWithMarks(Request $request, string $id, string $type){
        $payload = [];
        $students = SchoolClass::find($id)->students()->get();
        foreach ($students as $student) {
            array_push(
                $payload,
                [
                    'student' => $student,
                    'markData' => $student->atomicMarkData($request->period, $type),
                ],
            );
        }
        return response()->json($payload, 200);
    }

    public function divisionMetrics(Request $request, string $id, string $type){
        $classItem = SchoolClass::find($id);
        $payload = [];
        $I = $II = $III = $IV = $U = 0;
        $students = $classItem->students;

        foreach ($students as $student) {
            $division = $student->atomicMarkData($request->period, $type)['division'];
            switch ($division) {
                case 'I':
                    $I++;
                    break;

                case 'II':
                    $II++;
                    break;

                case 'III':
                    $III++;
                    break;

                case 'IV':
                    $IV++;
                    break;

                default:
                    $U++;
                    break;
            }
        }

        $payload = [
            ['division' => 'I', 'count' => $I],
            ['division' => 'II', 'count' => $II],
            ['division' => 'III', 'count' => $III],
            ['division' => 'IV', 'count' => $IV],
            ['division' => 'U', 'count' => $U],
        ];

        return response()->json($payload, 200);
    }

    public function getGradingPerSubject(Request $request, string $id, string $type){
        $payload = SchoolClass::find($id)->gradesPerSubject($request->period->id, $type);
        return response()->json($payload, 200);
    }

    public function getRequirements(Request $request, string $id){
        $requirements = SchoolClass::find($id)->requirements()->where('period_id', $request->period->id)->get();
        return response()->json($requirements, 200);
    }

    public function store(Request $request)
    {
        $schoolClass = SchoolClass::create([
            'name' => $request->name,
            'classteacher_id' => $request->classteacher_id,
        ]);
        return response()->json($schoolClass, 200);
    }

    public function show(string $id)
    {
        $schoolClass = SchoolClass::with(['classTeacher', 'subjects', 'gradings', 'requirements', 'students'])->find($id);
        return response()->json($schoolClass, 200);
        return view('class.details', ['class' => $schoolClass, 'periods' => Period::all()]);
    }

    public function update(Request $request, string $id)
    {
        $schoolClass = SchoolClass::find($id);

        if($request->has('fees_boarding')){
            $schoolClass->fees_boarding = $request->fees_boarding;
        }
        if($request->has('fees_day')){
            $schoolClass->fees_day = $request->fees_day;
        }

        if($request->has('classteacher_id')){
            $schoolClass->classteacher_id = $request->classteacher_id;
        }
        $schoolClass->save();

        return response()->json($schoolClass, 200);
    }

    public function destroy(string $id)
    {
        SchoolClass::destroy([$id]);
        return response()->json(['updated succesfully'], 200);
    }

    public function uploadMarksheetViaExcel(Request $request, string $id, string $type){
        if(!$request->hasFile('excelfile')){
            return response()->json(['message' => 'No excelfile detected'], 400);
        }
        if(!$request->has('period')){
            return response()->json(['message' => 'You can not upload marks when the term is over. You
            have to extend periods in the [academia > calendar] section'], 400);
        }
        $excelFile = $request->file('excelfile');
        $period = $request->period;
        $spreadsheet = IOFactory::load($excelFile);
        $class = SchoolClass::find($id);
        $students = $class->students;
        $subjects = $class->subjects;

        //row to start reading excel-file
        $startIndex = 0;
        //row where we shall find the subject names as headings
        $headerRow = [];

        $successful = 0;
        $uploaded = 0;
        $invalidNames = [];

        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();


        //first get the row starting with 'NAME' cell, we'll start reading the
        //excelfile from here
        foreach ($rows as $index => $row) {
            if(strtoupper($row[0]) == 'NAME'){
                $headerRow = $row;//subject names are on this same row
                $startIndex = $index + 1;//we'll start reading from the next row
                break;
            }else if($index == count($rows) - 1){
                return response()->json(
                    ['message' => 'We did not find any row starting with the NAME cell, Please make sure their
                    is a column starting with the heading NAME. That is where the code starts reading']
                    , 400);
            }
        }

        $subjectIds = [0];
        for($i = 1; $i < count($headerRow); $i++){
            $subject = $subjects::where('name', $headerRow[$i])->first();
            if(!$subject){
                return response()->json(
                    ["message" => "Subject named '" + $headerRow[i] + "' not found in our database. Please check it's spelling"],
                    404);
            }
            $subjectIds[i] = $subject->id;
        }

        for($i = $startIndex; $i < count($rows); $i++){
            $row = $rows[$i];

            $uploaded++;

            $name = $row[0];

            $student = $students::where('name', $name)->first();
            if(!$student){
                array_push($invalidNames, $name);
                continue;
            }

            for($j = 1; $j < count($row); $j++) {
                $mark = $row[$j];
                if(!$mark) continue;
                if(!$subjectIds[$j]) continue;

                $subjectid = $subjectIds[$j];
                $saved = $student->marks()->where('subject_id', $subjectid)->where('period_id', $period->id)->where('type', $type)->first();
                if($saved && $saved->mark !== $mark){
                    $saved->mark = $mark;
                    $saved->save();
                }else if(!$saved){
                    Marks::create([
                        'student_id' => $student->id,
                        'subject_id' => $subjectid,
                        'period_id'=> $period->id,
                        'type' => $type,
                        'mark' => $mark,
                    ]);
                }
            }
            $successful++;
        }
        $result = ['invalid_names' => $invalidNames, 'uploaded' => $uploaded, 'succesful' => $successful];
        return response()->json($result, 200);
    }
}
