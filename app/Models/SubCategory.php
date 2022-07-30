<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'fees_subcategory';

    protected $fillable = [
        'fee_subcategory_id', 'school_id', 'YearId', 'fee_category_id', 'fee_subcategory_name','amount', 'fee_type'
    ];
    public $timestamps = false;
}
