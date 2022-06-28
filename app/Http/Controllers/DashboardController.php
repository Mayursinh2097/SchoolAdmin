<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use Response;
use DB;
use Session;
use Redirect;

class DashboardController extends Controller
{
    // protected $user;
    public function __construct()
    {
        // $this->middleware('auth');
    }
   
    public function index(Request $request)
    {
        $data = Session::all();
        // $school_id = $data['school_id'];
        // $year_id = $_COOKIE['year'];
        $school_id = $_COOKIE['user'];
        $year_id = $_COOKIE['year'];
// echo "Hello".$school_id;exit;
        $students = DB::table('student_roll_number')
                ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
                ->join('class_master', 'class_master.ClassId', '=', 'student_roll_number.Current_Class')
                ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
                ->where('student_roll_number.IsDelete', '=', '0')
                ->where('student_roll_number.school_id', '=', $school_id)
                ->where('student_roll_number.Year_Id', '=', $year_id)
                ->count();
    	return view('admin_dashboard', compact('students'));
    }
}