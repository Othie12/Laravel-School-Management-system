<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'subject_class', 'subject_id', 'class_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'subject_id');
    }

}
