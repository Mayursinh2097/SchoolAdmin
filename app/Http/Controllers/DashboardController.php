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
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];
        // $school_id = $data['school_id'];
        // $year_id = $_COOKIE['year'];
        // $school_id = $_COOKIE['user'];
        // $year_id = $_COOKIE['year'];


        $dataset_schoolall = DB::table('school_master')->select('school_id', 'schoolname')->where('trusty_sid', '=', $sid)->where('IsDelete', '=', '0')->where('status', '=', '0')->get();

        $dataset_yearall= DB::table('year_master')->select('YearId', 'StartYear', 'EndYear', 'YEAR')->where('IsDelete', '=', '0')->get();

        $dataset_school1 = DB::table('school_master')->select('school_id', 'schoolname')->where('trusty_sid', '=', $sid)->where('IsDelete', '=', '0')->first();

        $dt = date('Y-m-d');

        $dataset_y= DB::table('year_master')->select('year_master.*')->whereRaw('"'.$dt.'" between `StartYear` and `EndYear`')->first();

        $cookie_name = 'user';
        if($RoleId == 1)
        {
            if(!isset($_COOKIE['user']))
            {
                //echo "Hii";exit;
                $school_id = $dataset_school1->school_id;
                $school_name = $dataset_school1->schoolname;
            }
            else
            {
                //echo "Hii Else".$_COOKIE[$cookie_name];exit;
                $school_id = $_COOKIE[$cookie_name];

                $school = DB::table('school_master')->select('schoolname')->where('school_id', '=', $school_id)->where('IsDelete', '=', '0')->first();
                $school_name = $school->schoolname;
            }
        }
        else
        {
           // echo "Hello";exit;
            $school_id = session()->get('school_id');
            $school_name = session()->get('school_name');
        }

        if(!isset($_COOKIE['year'])) 
        {
            $year_id = $dataset_y->YearId;
            //echo "Hii".$year_id;exit;
        }
        else
        {
            $year_id = $_COOKIE['year'];
            //echo "HiiElse".$year_id;exit;

        }


// echo "Hello".$school_id;exit;
        $students = DB::table('student_roll_number')
                ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
                ->join('class_master', 'class_master.ClassId', '=', 'student_roll_number.Current_Class')
                ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
                ->where('student_roll_number.IsDelete', '=', '0')
                ->where('student_roll_number.school_id', '=', $school_id)
                ->where('student_roll_number.Year_Id', '=', $year_id)
                ->count();
    	return view('admin_dashboard', compact('students', 'school_id', 'year_id'));
    }
}