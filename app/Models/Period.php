<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $table = 'period';

    protected $fillable = [
        'name',
        'date_from',
        'date_to',
    ];

    public function nxt()//: Period
    {
        if($this->name == 'Third term')
            return Period::where('name', 'First term')->first();
        else if($this->name == 'First term')
            return Period::where('date_from', '>', $this->date_from)->where('name', 'Second term')->first();
        else if($this->name == 'Second term')
            return Period::where('date_from', '>', $this->date_from)->where('name', 'Third term')->first();
    }
}
