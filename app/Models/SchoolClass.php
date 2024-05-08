<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $fillable = ['name', 'classteacher_id', 'fees_day', 'fees_boarding'];
    protected $appends = ['girls', 'boys'];
    protected $guarded = ['id'];

    public function classTeacher()
    {
        return $this->belongsTo(User::class, 'classteacher_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_class', 'class_id', 'subject_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_class', 'class_id', 'teacher_id');
    }

    public function gradings()
    {
        return $this->hasMany(Grading::class, 'class_id');
    }

    public function divisions()
    {
        return $this->hasMany(Division::class, 'class_id');
    }

    public function requirements()
    {
        return $this->hasMany(Requirements::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'class_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'class_id');
    }

    public function schFees(){
        return $this->requirements->where('name', 'schoolfees')->get();
    }

    //this might slow down the loading page in the future
    public function getGirlsAttribute() {
        return $this->students->where('sex', 'f')->count();
    }

    public function getBoysAttribute(){
        return $this->students->where('sex', 'm')->count();
    }

    public function gradesPerSubject(string $periodId, string $type){
        $subjects = [];
        $D1 = [];
            foreach($this->subjects as $subject){
                array_push($subjects, $subject->name);
                array_push($D1, 0);
            }
        $D2 = $D1;
        $C3 = $D1;
        $C4 = $D1;
        $C5 = $D1;
        $C6 = $D1;
        $P7 = $D1;
        $P8 = $D1;
        $F9 = $D1;
        $N = $D1;

        $studentIds = [];
        foreach ($this->students as $student) {
            array_push($studentIds, $student->id);
        }

        $marks = Marks::whereIn('student_id', $studentIds)
            ->where('period_id', $periodId)
            ->where('type', $type)->get();

        foreach ($marks as $mark) {
            switch ($mark->grading()->grade) {
                case 1:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $D1[$key]++;
                        }
                    }
                    break;

                case 2:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $D2[$key]++;
                        }
                    }
                    break;

                case 3:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $C3[$key]++;
                        }
                    }
                    break;

                case 4:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $C4[$key]++;
                        }
                    }
                    break;

                case 5:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $C5[$key]++;
                        }
                    }
                    break;

                case 6:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $C6[$key]++;
                        }
                    }
                    break;

                case 7:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $P7[$key]++;
                        }
                    }
                    break;

                case 8:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $P8[$key]++;
                        }
                    }
                    break;

                case 9:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $F9[$key]++;
                        }
                    }
                    break;

                default:
                    foreach ($subjects as $key => $value) {
                        if($mark->subject->name == $value){
                            $N[$key]++;
                        }
                    }
                    break;
            }
        }
        return [
        'subjects' => $subjects,
        'items' => [
            ['agg' => 'D1', 'metric' => $D1],
            ['agg' => 'D2', 'metric' => $D2],
            ['agg' => 'C3', 'metric' => $C3],
            ['agg' => 'C4', 'metric' => $C4],
            ['agg' => 'C5', 'metric' => $C5],
            ['agg' => 'C6', 'metric' => $C6],
            ['agg' => 'P7', 'metric' => $P7],
            ['agg' => 'P8', 'metric' => $P8],
            ['agg' => 'F9', 'metric' => $F9],
            ['agg' => 'N/A', 'metric' => $N],
        ]
    ];
    }

    public function prev(): SchoolClass {
        switch ($this->name) {
            case 'MIDDLE':
                return SchoolClass::where('name', 'BABY')->first();
                break;
            case 'TOP':
                return SchoolClass::where('name', 'MIDDLE')->first();
                break;
            case 'P.1':
                return SchoolClass::where('name', 'TOP')->first();
                break;
            case 'P.2':
                return SchoolClass::where('name', 'P.1')->first();
                break;
            case 'P.3':
                return SchoolClass::where('name', 'P.2')->first();
                break;
            case 'P.4':
                return SchoolClass::where('name', 'P.3')->first();
                break;
            case 'P.5':
                return SchoolClass::where('name', 'P.4')->first();
                break;
            case 'P.6':
                return SchoolClass::where('name', 'P.5')->first();
                break;
            case 'P.7':
                return SchoolClass::where('name', 'P.6')->first();
                break;

            default:
                return null;
                break;
        }
    }

    public function next(): SchoolClass {
        switch ($this->name) {
            case 'BABY':
                return SchoolClass::where('name', 'MIDDLE')->first();
                break;
            case 'MIDDLE':
                return SchoolClass::where('name', 'TOP')->first();
                break;
            case 'TOP':
                return SchoolClass::where('name', 'P.1')->first();
                break;
            case 'P.1':
                return SchoolClass::where('name', 'P.2')->first();
                break;
            case 'P.2':
                return SchoolClass::where('name', 'P.3')->first();
                break;
            case 'P.3':
                return SchoolClass::where('name', 'P.4')->first();
                break;
            case 'P.4':
                return SchoolClass::where('name', 'P.5')->first();
                break;
            case 'P.5':
                return SchoolClass::where('name', 'P.6')->first();
                break;
            case 'P.6':
                return SchoolClass::where('name', 'P.7')->first();
                break;

            default:
                return null;
                break;
        }
    }
}
