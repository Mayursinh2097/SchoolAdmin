<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    use HasFactory;
    protected $table = 'student_master';

    protected $fillable = [
    	'StudentId', 'school_id', 'StudentName', 'RollNumber', 'BirthPlace', 'AadharNumber', 'Gender', 'Photo', 'dob', 'age', 'admission_year_id', 'type_admission', 'hostel_type', 'cast', 'subcast', 'ifsc_code', 'passbook_name', 'prev_result', 'prev_grade', 'bpl_card_num', 'CategoryId', 'ReligionId', 'FatherName', 'FatherOccupation', 'FatherEducation', 'MotherOccupation', 'MotherName', 'lblCaste', 'MothersEucation', 'PermenantAddress', 'CurrentAddress', 'ContactNumber1', 'ContactNumber2', 'password', 'app_token', 'app_version', 'AdmissionDate', 'FirstAdmission', 'PreviousSchoolId', 'PreGRNumber', 'PreviousAttendedClassId', 'ClassId', 'DivisionId', 'MediumId', 'DeviceID', 'uid_number', 'GRNumber', 'acc_number', 'bank_name', 'bank_branch', 'LC_number', 'udias_number', 'RTE', 'medical_issue', 'TokenId', 'lc_id',
    ];
    public $timestamps = false;
}
