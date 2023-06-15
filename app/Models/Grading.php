<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    use HasFactory;

    protected $table = 'grading';

    protected $fillable = [
        'class_id',
        'marks_from',
        'marks_to',
        'grade',
        'remark',
        'locked',
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
