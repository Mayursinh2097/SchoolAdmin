<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentRollNumber extends Model
{
    use HasFactory;
    protected $table = 'student_roll_number';

    protected $fillable = [
    	'Student_RollNumber_Id', 'school_id', 'Student_id', 'Roll_Number', 'Prev_Class', 'Prev_Div', 'Current_Class', 'Current_Div', 'Year_Id', 'lc_id',
    ];
    public $timestamps = false;
}
