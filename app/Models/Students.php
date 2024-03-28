<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Students extends Model

{
    use HasFactory;

    protected $table = 'students';

    protected $appends = [
        'periods',
    ];

    protected $fillable = [
        'name',
        'sex',
        'dob',
        'doj',
        'dol',
        'section',
        'profile_pic_filepath',
        'parent_id',
        'class_id',
        'custom_ct_comm',
        'custom_ht_comm',
        'times_promoted',
        'last_promoted',
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


    public function getPeriodsAttribute()
    {
        $today = Carbon::now();
        if($this->doj && $this->dol){
            return Period::where('date_to', '>=', $this->doj)->where('date_from', '<=', $this->dol)->get();
        }
        if($this->doj && !$this->dol){
            return Period::where('date_to', '>=', $this->doj)->where('date_from', '<=', $today)->get();
        }
        if(!$this->doj && $this->dol){
            return Period::where('date_to', '>=', $this->created_at)->where('date_from', '<=', $this->dol)->get();
        }
        return Period::where('date_to', '>=', $this->created_at)->where('date_from', '<=', $today)->get();
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
        $totalAgg = 0;//Gonna use it to get the total aggregate mark in all subjects
        $totalAggMid = 0;//Gonna use it to get the total aggregate mark in all subjects
        $totalAggEnd = 0;//Gonna use it to get the total aggregate mark in all subjects
        $totalMarksMid = 0;
        $totalMarksEnd = 0;
        $totalMarks = 0;//Gonna use it to get the total marks in all subjects
        $count = 0;//gonna use it to get the total number of subjects which i'll later use to get the optimal overal mark

        foreach ($this->class->subjects as $subject){
            $markMid = $subject->marks->where('student_id', $this->id)->where('period_id', $period->id)->where('type', 'mid')->first();
            $markEnd = $subject->marks->where('student_id', $this->id)->where('period_id', $period->id)->where('type', 'end')->first();
            $aggMid = $markMid !== null && $markMid->grading() !== null ? $markMid->grading()->grade : 0;
            $remarkMid = $markMid !== null && $markMid->grading() !== null ? $markMid->grading()->remark : 'N/A';
            $aggEnd = $markEnd !== null && $markEnd->grading() ? $markEnd->grading()->grade : 0;
            $remarkEnd = $markEnd !== null && $markEnd->grading() ? $markEnd->grading()->remark : 'N/A';

            $totalMarksMid = $markMid != null ? $markMid->mark + $totalMarksMid : $totalMarksMid;
            $totalMarksEnd = $markEnd != null ? $markEnd->mark + $totalMarksEnd : $totalMarksEnd;

            $totalAggMid += $aggMid;
            $totalAggEnd += $aggEnd;

            //looking forward to discarding this
            $agg = ($aggMid + $aggEnd) / 2;
            $mm = $markMid ? $markMid->mark : null;
            $me = $markEnd ? $markEnd->mark : null;
            $mark = ($mm && $mm > 0 || $me && $me > 0) ? ($mm + $me) / 2 : 0;
            $totalMarks += $mark;
            $count++;

            array_push($subData, ['name' => $subject->name, 'subjectId' =>  $subject->id,
                        'markMidId' => $markMid ? $markMid->id : null,
                        'markEndId' => $markEnd ? $markEnd->id : null,
                        'markMid' => $mm, 'aggMid' => $aggMid, 'remarkMid' => $remarkMid,
                        'markEnd' => $me, 'aggEnd' => $aggEnd, 'remarkEnd' => $remarkEnd,
                        'mark' => ceil($mark), 'agg' => $agg]
            );
        }
        return ['subdata' => $subData, 'totalMarks' => $totalMarks, 'totalAggMid' => $totalAggMid, 'totalAggEnd' => $totalAggEnd];
    }

    public function atomicMarkData(Period $period, string $type){
        $subData = [];
        $totalAgg = 0;
        $totalMarks = 0;
        foreach ($this->class->subjects as $subject){
            $item = $subject->marks->where('student_id', $this->id)->where('period_id', $period->id)->where('type', $type)->first();
            $agg = $item !== null && $item->grading() !== null ? $item->grading()->grade : 0;
            $remark = $item !== null && $item->grading() !== null ? $item->grading()->remark : 'N/A';

            $totalMarks = $item != null ? $item->mark + $totalMarks : $totalMarks;

            $totalAgg += $agg;

            $mark = $item ? $item->mark : null;

            array_push(
                $subData,
                [
                    'name' => $subject->name, 'subjectId' =>  $subject->id,
                    'mark' => $mark, 'agg' => $agg, 'remark' => $remark
                ]
                );
        }
        $divisionObj = Division::where('aggs_from', '<=', $totalAgg)->where('aggs_to', '>=', $totalAgg)->first();
        $division = $divisionObj ? $divisionObj->division : null;
        return ['studentId' => $this->id, 'subdata' => $subData, 'totalMarks' => $totalMarks, 'totalAgg' => $totalAgg, 'division' => $division];
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function balanceObjs(){
        return $this->hasMany(Balance::class, 'student_id');
    }

    public function balanceObjectSum(){
        return $this->balanceObjs()->sum('balance');
    }

    /*
    *Function to calculate total schoolfees balance of this student.
    *created this one to cater for some terms where the student has not yet recorded any single
    *payment so their balance for these terms hasn't been recorded at all
    **/
    public function getBalanceAttribute(): int{
        $periods = $this->periods;
        $classFees = $this->section === 'Day' ? $this->class->fees_day : $this->class->fees_boarding;

        $balance = $this->balanceObjectSum();
        foreach ($periods as $period) {
            $periodBalanceObject = Balance::where('student_id', $this->id)->where('period_id', $period->id)->first();
            if($periodBalanceObject){
                continue;
            }
            $balance += $classFees;
        }
        return $balance;
    }
}
