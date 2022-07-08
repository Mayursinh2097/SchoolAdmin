<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;
    protected $table = 'fees_category';

    protected $fillable = [
    	'fee_category_id', 'school_id', 'fee_category_name', 'receipt_prefix', 'description'
        
    ];
    public $timestamps = false;
}
