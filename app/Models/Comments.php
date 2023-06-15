<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $table = 'comments';

    protected $fillable = [
        'class_id',
        'agg_from',
        'agg_to',
        'ht_comm',
        'ct_comm',
    ];

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
