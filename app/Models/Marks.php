<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Marks extends Model
{
    use HasFactory;

    protected $table = 'marks';

    protected $fillable = [
        'student_id',
        'subject_id',
        'period_id',
        'type',
        'mark',
        'year',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
    public function grading()
    {
        $mark = $this->mark;
        $grading = DB::select("SELECT g.*, s.name FROM grading g JOIN students s JOIN class c
                                ON c.id = g.class_id AND c.id = s.class_id WHERE s.id = ?
                                AND g.marks_from <= ? AND g.marks_to >= ? LIMIT 1",
                                [$this->student_id, $mark, $mark]);

        return !empty($grading) ? $grading[0] : null;
        //return Grading::where('marks_from', '<=', $this->mark)->where('marks_to', '>=', $this->mark)->first();
    }
}
