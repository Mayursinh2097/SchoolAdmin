<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';

    protected $fillable = [
    	'id', 'subject', 'school_id',        
    ];
    public $timestamps = false;
}
