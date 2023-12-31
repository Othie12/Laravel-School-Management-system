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

    public function nxt(): Period
    {
        return $this->name === 'Third term' ? Period::where('name', 'First term')->first() : Period::where('id', '>', $this->id)->first();
    }
}
