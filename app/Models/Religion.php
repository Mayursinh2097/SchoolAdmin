<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Religion extends Model
{
    use HasFactory;
    protected $table = 'religion_master';

    protected $fillable = [
    	'ReligionId', 'ReligionName',        
    ];
    public $timestamps = false;
}
