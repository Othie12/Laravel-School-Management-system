<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $table = 'balance';
    protected $fillable = [
        'student_id',
        'period_id',
        'balance',
    ];

    public function student(){
        return $this->belongsTo(student::class, 'student_id');
    }

    public function Period(){
        return $this->belongsTo(Period::class, 'period_id');
    }
}
