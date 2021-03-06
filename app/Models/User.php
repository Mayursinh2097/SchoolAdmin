<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user_master';
    protected $fillable = [
        'UserId', 'UserName', 'school_id', 'RollId', 'Name', 'Address', 'Gender', 'email', 'ContactNumber1', 'ContactNumber2', 'Password', 'photo', 'SchoolJoining', 'dob', 'PCNumber', 'DLNumber', 'GPFNumber', 'CPFNumber', 'SeniorityNumber', 'MandaniNumber', 'BankAccountNumber', 'BankName', 'BankBranch', 'BranchCode', 'VoterCardNumber', 'ShiftId', 'TeacherTypeId', 'EmploymentNumber', 'DeviceUserID', 'UniqueCode', 'PasswordCode', 'IMEINO', 'status', 'LastMilliSecond'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
