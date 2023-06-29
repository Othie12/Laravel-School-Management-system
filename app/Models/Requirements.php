<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    use HasFactory;

    protected $table = 'requirements';

    protected $fillable = [
        'class_id',
        'period_id',
        'name',
        'quantity',
        'price',
        'compulsary'
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
