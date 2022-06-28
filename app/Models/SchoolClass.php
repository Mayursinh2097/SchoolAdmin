<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SchoolClass extends Model
{
    use HasFactory;
    protected $table = 'class_master';

    protected $fillable = [
    	'ClassId', 'school_id ','ClassName','class_type','stream'
        
    ];
    public $timestamps = false;
}
