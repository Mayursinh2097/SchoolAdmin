<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StudentLC extends Model
{
    use HasFactory;
    protected $table = 'student_lc';

    protected $fillable = [
    	'id', 'student_id ', 'Year_Id', 'lc_number', 'progress', 'conduct', 'attendance', 'date_of_leaving', 'class_at_leaving', 'reason_of_leaving', 'remark'        
    ];
    public $timestamps = false;
}
