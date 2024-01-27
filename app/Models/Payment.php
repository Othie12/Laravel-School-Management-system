<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class Payment extends Model
{
    use HasFactory;


    protected $table = 'payments';

    protected $fillable = [
        'student_id',
        'amount',
        'balance',
        'reason',
        'payement_method',
        'date_paid',
        'picture',
        'hash',
    ];

    public function student() {
        return $this->belongsTo(Students::Class, 'student_id');
    }
}
