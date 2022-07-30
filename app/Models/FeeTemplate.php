<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeeTemplate extends Model
{
    use HasFactory;
    protected $table = 'fee_template';

    protected $fillable = [
    	'template_id', 'school_id', 'year_id', 'fee_category_id', 'template_name', 'institution_details', 'photo', 'institution_name', 'institution_address', 'phone_number'
    ];
    public $timestamps = false;
}
