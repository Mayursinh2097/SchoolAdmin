<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SchoolClassDiv extends Model
{
    use HasFactory;
    protected $table = 'division_master';

    protected $fillable = [
    	'DivisionId', 'ClassId', 'school_id ','DivisionName'
        
    ];
    public $timestamps = false;
}
