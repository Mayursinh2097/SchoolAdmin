<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeeDates extends Model
{
    use HasFactory;
    protected $table = 'fee_dates';

    protected $fillable = [
    	'fee_date_id', 'school_id', 'fee_type_id', 'fee_type', 'start_date', 'due_date', 'end_date', 'installment_amount'
    ];
    public $timestamps = false;
}
