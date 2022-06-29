<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class District extends Model
{
    use HasFactory;
    protected $table = 'district_master';

    protected $fillable = [
    	'district_id', 'state_id', 'district_name',        
    ];
    public $timestamps = false;
}
