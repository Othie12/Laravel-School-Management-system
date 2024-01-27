<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'name',
        'sex',
        'dob',
        'profile_pic_filepath',
        'parent_id',
        'class_id',
        'custom_ct_comm',
        'custom_ht_comm',
        'times_promoted',
        'last_promoted',
        'balance'
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'student_id');
    }

    public function periods()
    {
        return Period::where('date_to', '>=', $this->created_at)->get();
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function already_promoted()
    {
        if ($this->last_promoted) {
            $year = Carbon::parse($this->last_promoted)->year;

            return $year === Carbon::now()->year ? true : false;
        }
        return false;
    }

    public function markData(Period $period){
        $subData = [];
        //$period = Period::find(2);
        $totalAgg = 0;//Gonna use it to get the total aggregate mark in all subjects
        $totalMarks = 0;//Gonna use it to get the total marks in all subjects
        $count = 0;//gonna use it to get the total number of subjects which i'll later use to get the optimal overal mark
        foreach ($this->class->subjects as $subject){
            $markMid = $subject->marks->where('student_id', $this->id)->where('period_id', $period->id)->where('type', 'mid')->first();
            $markEnd = $subject->marks->where('student_id', $this->id)->where('period_id', $period->id)->where('type', 'end')->first();
            $gradeMid = $markMid !== null ? $markMid->grading()->grade : 9;
            $gradeEnd = $markEnd !== null ? $markEnd->grading()->grade : 9;
            $agg = ($gradeMid + $gradeEnd) / 2;
            $mm = $markMid ? $markMid->mark : 0;
            $me = $markEnd ? $markEnd->mark : 0;
            $mark = ($mm > 0 || $me > 0) ? ($mm + $me) / 2 : 0;
            $totalMarks += $mark;
            $count++;

            array_push($subData, ['name' => $subject->name, 'subjectId' =>  $subject->id,
                        'markMidId' => $markMid ? $markMid->id : null,
                        'markEndId' => $markEnd ? $markEnd->id : null,
                        'markMid' => $mm, 'aggMid' => $gradeMid, 'markEnd' => $me,
                        'aggEnd' => $gradeEnd, 'mark' => ceil($mark), 'agg' => $agg]
            );
        }
        return $subData;
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'student_id');
    }
}
