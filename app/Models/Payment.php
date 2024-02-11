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
        'period_id',
        'balance_id',
        'amount',
        'balance',
        'times_updated',
        'reason',
        'payement_method',
        'date_paid',
        'picture',
        'hash',
    ];

    public function student() {
        return $this->belongsTo(Students::Class, 'student_id');
    }

    public function Period() {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function getBalanceObjAttribute() {
        return Balance::where('student_id', $this->student_id)->where('period_id', $this->period_id)->first();
    }

    public function BalanceObject(){
        return $this->belongsTo(Balance::class, 'balance_id');
    }
}
