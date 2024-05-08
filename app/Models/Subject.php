<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';

    protected $fillable = [
        'name',
    ];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }

    public function teacher(string $class_id){
        $item = DB::scalar("SELECT t.name FROM subject_teacher st
                            JOIN teacher_class tc JOIN users t ON st.teacher_id = tc.teacher_id
                            AND t.id = tc.teacher_id WHERE st.subject_id = :sid AND tc.class_id = :cid LIMIT 1",
                            ['sid' => $this->id, 'cid' => $class_id]);
        return $item ? $item : '';
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'subject_class', 'subject_id', 'class_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'subject_id');
    }

}
