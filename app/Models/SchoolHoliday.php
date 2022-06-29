<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SchoolHoliday extends Model
{
    use HasFactory;
    protected $table = 'holiday_master';

    protected $fillable = [
    	'holiday_id', 'year_id', 'school_id ', 'holiday_date', 'holiday_name',
        
    ];
    public $timestamps = false;
}
