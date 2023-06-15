<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $fillable = ['name', 'classteacher_id'];
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

    public function requirements()
    {
        return $this->hasMany(Requirements::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'class_id');
    }
}
