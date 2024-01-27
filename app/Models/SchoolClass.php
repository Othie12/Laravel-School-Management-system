<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $fillable = ['name', 'classteacher_id', 'fees'];
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

    public function comments()
    {
        return $this->hasMany(Comments::class, 'class_id');
    }

    public function schFees(){
        return $this->requirements->where('name', 'schoolfees')->get();
    }

    public function girlsCount(): int {
        return $this->students->where('sex', 'f')->count();
    }

    public function boysCount(): int{
        return $this->students->where('sex', 'm')->count();
    }

    public function prev(): SchoolClass {
        switch ($this->name) {
            case 'MIDDLE':
                return SchoolClass::where('name', 'BABY')->first();
                break;
            case 'TOP':
                return SchoolClass::where('name', 'MIDDLE')->first();
                break;
            case 'P.1':
                return SchoolClass::where('name', 'TOP')->first();
                break;
            case 'P.2':
                return SchoolClass::where('name', 'P.1')->first();
                break;
            case 'P.3':
                return SchoolClass::where('name', 'P.2')->first();
                break;
            case 'P.4':
                return SchoolClass::where('name', 'P.3')->first();
                break;
            case 'P.5':
                return SchoolClass::where('name', 'P.4')->first();
                break;
            case 'P.6':
                return SchoolClass::where('name', 'P.5')->first();
                break;
            case 'P.7':
                return SchoolClass::where('name', 'P.6')->first();
                break;

            default:
                return null;
                break;
        }
    }

    public function next(): SchoolClass {
        switch ($this->name) {
            case 'BABY':
                return SchoolClass::where('name', 'MIDDLE')->first();
                break;
            case 'MIDDLE':
                return SchoolClass::where('name', 'TOP')->first();
                break;
            case 'TOP':
                return SchoolClass::where('name', 'P.1')->first();
                break;
            case 'P.1':
                return SchoolClass::where('name', 'P.2')->first();
                break;
            case 'P.2':
                return SchoolClass::where('name', 'P.3')->first();
                break;
            case 'P.3':
                return SchoolClass::where('name', 'P.4')->first();
                break;
            case 'P.4':
                return SchoolClass::where('name', 'P.5')->first();
                break;
            case 'P.5':
                return SchoolClass::where('name', 'P.6')->first();
                break;
            case 'P.6':
                return SchoolClass::where('name', 'P.7')->first();
                break;

            default:
                return null;
                break;
        }
    }
}
