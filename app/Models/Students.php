<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'name',
        'sex',
        'dob',
        'profile_pic_filepath',
        'parent_id',
        'class_id',
        'custom_ct_comm',
        'custom_ht_comm',
        'times_promoted',
        'last_promoted',
    ];

    public function parent()
    {
        return $this->belongsTo(Parents::class, 'parent_id');
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function marks()
    {
        return $this->hasMany(Marks::class, 'student_id');
    }

    public function periods()
    {
        return Period::where('date_to', '>=', $this->created_at)->get();
    }

    public function already_promoted()
    {
        if ($this->last_promoted) {
            $year = Carbon::parse($this->last_promoted)->year;

            return $year === Carbon::now()->year ? true : false;
        }
        return false;
    }

}
