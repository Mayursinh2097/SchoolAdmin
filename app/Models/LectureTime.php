<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class LectureTime extends Model
{
    use HasFactory;
    protected $table = 'lecture_time';

    protected $fillable = [
    	'lecture_id', 'school_id', 'year_id', 'day_id', 'lecture_name', 'start_time', 'end_time',
        
    ];
    public $timestamps = false;
}
