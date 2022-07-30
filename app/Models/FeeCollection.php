<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FeeCollection extends Model
{
    use HasFactory;
    protected $table = 'fee_collection';

    protected $fillable = [
    	'fee_collection_id', 'school_id', 'Year_Id', 'class_id', 'student_id', 'fee_subcategory_id', 'fee_type', 'actual_amount', 'due_amount', 'duetobepaid', 'fine', 'discount', 'scholarship', 'is_paid', 'mode_of_pay', 'remarks', 'school_no', 'receipt_id', 'bank_name',  'cheque_no', 'cheque_date', 'paid_date', 'IsDelete'       
    ];
    public $timestamps = false;
}
