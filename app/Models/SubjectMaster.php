<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubjectMaster extends Model
{
    use HasFactory;
    protected $table = 'subject_master';

    protected $fillable = [
    	'SubjectId', 'ClassId', 'school_id', 'year_id', 'SubjectName',
        
    ];
    public $timestamps = false;
}
