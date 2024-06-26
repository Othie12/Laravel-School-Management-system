<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Parents;
use App\Models\Period;
use App\Models\User;
use App\Models\Comments;
use App\Models\Requirements;
use App\Models\SchoolClass;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{

    public function index(string $limit, string $offset)
    {
        $students = Students::limit($limit)->offset($offset)->orderBy('name')->get();
        return response()->json($students, 200);
    }

    public function search(string $term){
        $students = Students::where('name', 'like', "%$term%")->limit(10)->get();
        return response()->json($students, 200);
    }


    public function batchExcelUpload(Request $request){
        if(!$request->hasFile('excelfile')){
            return response()->json(['message' => 'No excelfile detected'], 400);
        }
        $excelFile = $request->file('excelfile');
        $spreadsheet = IOFactory::load($excelFile);

        $successful = 0;
        $uploaded = 0;
        $invalidClass = 0;
        $duplicate = 0;
        $invalidSex = 0;
        $invalidSection = 0;

        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        foreach($rows as $row){
            if(strtoupper($row[0]) == 'NAME') continue;
            $uploaded++;

            $name = $row[0];
            $sex = strtolower($row[1]);
            $section = $row[2];
            $className = $row[3];
            //$doj = $row[4];

            if(strtoupper($section) === 'BOARDING') $section = 'Boarding';
            if(strtoupper($section) === 'DAY') $section = 'Day';

            $class = SchoolClass::where('name', $className)->first();
            if(!$class) {$invalidClass++;continue;}
            if(!($sex === 'm' || $sex === 'f')) {$invalidSex++; continue;}
            if(!($section !== 'Boarding' || $section !== 'Day')) {$invalidSection++; continue;}
            if($student = Students::where('name', $name)->first()){$duplicate++;continue;}

            $student = Students::create([
                'name' => $name,
                'sex' => $sex,
                'section' => $section,
                'class_id' => $class->id,
            ]);
            if($student) $successful++;
        }
        $result = ['succesful' => $successful,
                    'uploaded' => $uploaded,
                    'failed' => $uploaded - $successful,
                    'invalid_class' => $invalidClass,
                    'duplicates' => $duplicate,
                    'invalid_section' => $invalidSection,
                    'invalid_sex' => $invalidSex,
                ];
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $student = Students::create([
            'name' => $request->name,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'section' => $request->section,
            'class_id' => $request->class_id,
        ]);

        if($student && $request->has('doj')){
            $student->doj = $request->doj;
            $student = $student->save();
        }

        //if the parent id has been provided, save it to the database
        if($student && !empty($request->parent_id)){
            $student->parent_id = $request->parent_id;
            $student = $student->save();
        }


        //first check if the student's picture has been provided
        if ($student && $request->hasFile('picture')) {
            //store the profilepicture into the profile_picures dir in public and return the name and path
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            // Save the profile picture file path to the database
            $student->profile_pic_filepath = $profilePicturePath;
            $student = $student->save();
        }

        if($student){
            return response()->json('Saved successfuly', 200);
        }
        return response()->json('Failed to save student', 401);
    }

    public function show(string $id)
    {
        $student = Students::find($id)->load(['class', 'parent', 'payments', 'balanceObjs']);
        $student->append(['balance']);
        return $student ? response()->json($student, 200) : response()->json('Student not found', 401);
    }

    public function update(Request $request, string $id)
    {
        $student = Students::find($id);
        if($request->has('name')){
            $student->name = $request->name;
        }
        if($request->has('sex')){
            $student->sex = $request->sex;
        }
        if($request->has('dob')){
            $student->dob = $request->dob;
        }
        if($request->has('doj')){
            $student->doj = $request->doj;
        }
        if($request->has('dol')){
            $student->dol = $request->dol;
        }
        if($request->has('parent_id')){
            $student->parent_id = $request->parent_id;
        }
        if($request->has('class_id')){
            $student->class_id = $request->class_id;
        }
        if($request->has('section')){
            $student->section = $request->section;
        }
        if ($student && $request->hasFile('picture')) {
            return response()->json('pic seen/s', 200);
            $profilePicturePath = $request->file('picture')->store('profile_pictures', 'public');

            if(File::exists($student->profile_pic_filepath)){
                File::delete($student->profile_pic_filepath);
            }

            $student->profile_pic_filepath = $profilePicturePath;
        }

        if($student->save()){
            return response()->json('Updated succesfuly', 200);
        }
        return response()->json('Failed to update Student', 401);
    }

    public function updatePhoto(Request $request, string $id)
    {
        //return response()->json($request, 200);
        if(!$request->hasFile('pictureFile')){
            return response()->json(['message' => 'No picture detected'], 400);
        }

        // Get the student
        $student = Students::find($id);

        // Retrieve the student's current profile photo directory from the database
        $currentPhotoDirectory = $student->profile_pic_filepath;

        // Delete the current photo from the filesystem
        if ($currentPhotoDirectory) {
            Storage::delete($currentPhotoDirectory);
        }

        // Upload the new photo
        $newPhotoPath = $request->file('pictureFile')->store('profile_pictures', 'public');

        // Update the student's profile photo with the new photo
        $student->profile_pic_filepath = $newPhotoPath;
        $student->save();
        return response()->json(['message' => 'Profile photo updated succesfully'], 200);
    }


    public function searchParent(Request $request){
        $searchterm = $request->term;
        $parents = User::where('name', 'like', "%$searchterm%")->where('role', 'parent')->get();
        return response()->json($parents);
    }

    public function promote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        $currentYear = Carbon::now()->year;
        if ($student->last_promoted && $year === $currentYear) {
            return response()->json(['error' => 'Student can not be promoted twice a year'], 422);
        }else if($student->class->next == null){
            return response()->json(['error' => 'Candidates can not be promoted'], 422);
        }else{
            $student->times_promoted++;
            $student->last_promoted = $currentYear;
            $student->class_id = $student->class->next()->id;
            $student->save();
            return response()->json(['success' => 'Promoted Succesfully'], 200);
        }
    }

    public function demote(Request $request, string $id){
        $student = Students::find($id);
        $year = Carbon::parse($student->last_promoted)->year;
        if ($student->times_promoted <= 0 && $student->last_promoted && $year === Carbon::now()->subYear()->year) {
            return response()->json(['error' => 'Can not demote twice a year Succesfully'], 422);
        }else{
            $student->times_promoted--;
            $student->last_promoted = Carbon::now()->subYear();
            $student->save();
            return response()->json(['success' => 'Demoted Succesfully'], 200);
        }
    }


    public function destroy(Request $request, string $id)
    {
        $id = $request->id;
        /*$request->validateWithBag('studentDeletion', [
            'password' => ['required', 'current_password'],
        ]);*/

        //
        $student = Students::find($id);
        if($student->delete()){
            return response()->json(['message' => "Deleted succesfuly"], 200);
        }
        return response()->json(['message' => "Failed to delete student"], 401);
    }

    public function markData(Request $request, string $id, string $type){
        $data = Students::find($id)->atomicMarkData($request->period->id, $type);
        return response()->json($data, 200);
    }

    public function reportCard(string $id, string $period_id){
        $student = Students::find($id);
        $period = Period::find($period_id);
        $mid = $student->atomicMarkData($period_id, 'mid');
        $end = $student->atomicMarkData($period_id, 'end');
        $gradings = $student->class->gradings;
        $positionMid = $student->position($period_id, 'mid');
        $positionEnd = $student->position($period_id, 'end');

        $commentObj = Comments::where('agg_from', '<=', $end['totalMarks'])
                                ->where('agg_to', '>=', $end['totalMarks'])->first();

        $classTeacherObj = $student->class->classTeacher;
        $headTeacherObj = User::where('role', 'Head Teacher')->first();

        $classTeacher = $classTeacherObj ? $classTeacherObj->name : '';
        $headTeacher = $headTeacherObj ? $headTeacherObj->name : '';

        $requirements = Requirements::where('period_id', $period_id)
                            ->where('class_id', $student->class->id)->get();

        $payload = [
            'student' => $student,
            'midMarkData' => $mid,
            'endMarkData' => $end,
            'term' => $period,
            'nxtTerm' => $period->nxt(),
            'comments' => $commentObj,
            'classteacher' => $classTeacher,
            'headteacher' => $headTeacher,
            'requirements' => $requirements,
            'gradings' => $gradings,
            'positionMid' => $positionMid,
            'positionEnd' => $positionEnd,
        ];

        return response()->json($payload, 200);
    }

}
