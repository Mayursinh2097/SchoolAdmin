<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeeAllocation extends Model
{
    use HasFactory;
    protected $table = 'fee_allocation';

    protected $fillable = [
    	'fee_allocation_id', 'school_id', 'YearId', 'fee_category_id', 'fee_subcategory_id', 'ClassId', 'DivisionId', 'StudentId'
    ];
    public $timestamps = false;
}
