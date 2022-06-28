<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class School extends Model
{
    use HasFactory;
    protected $table = 'school_master';

    protected $fillable = [
    	'school_id ','trusty_sid','diseccode','schoolname','address','state_id','taluka_id' ,'latitude' ,'longitude' ,'registration_no' ,'year_establishment' ,'contact_no1' ,'contact_no2' ,'email' ,'MediumId' ,'school_no' ,'device_id' ,'user_id' ,'status' 
        
    ];
    public $timestamps = false;
}
