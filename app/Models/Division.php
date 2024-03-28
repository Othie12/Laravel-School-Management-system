<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'divisions';

    protected $fillable = [
        'class_id',
        'aggs_from',
        'aggs_to',
        'division',
    ];

    public function class(){
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
