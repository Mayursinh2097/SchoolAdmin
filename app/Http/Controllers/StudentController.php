<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolClassDiv;
use App\Models\State;
use App\Models\District;
use App\Models\Religion;
use App\Models\Subject;

use App\Models\Student;
use App\Models\StudentRollNumber;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use \Input;
use DB;
use Session;
use Response;
use Redirect;

class StudentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    ////////////////////////// Student //////////////////////////

    public function index()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        $classes = SchoolClass::select('ClassId', 'ClassName')
                ->where('school_id', '=', $school_id)
                ->where('IsDelete', '=', '0')
                ->get();

        $students = Student::select('student_roll_number.Roll_Number', 'student_master.StudentName', 'class_master.ClassName', 'division_master.DivisionName', 'student_master.GRNumber', 'student_master.ContactNumber1', 'student_master.Gender')
            ->join('student_roll_number', 'student_roll_number.Student_id', '=', 'student_master.StudentId')
            ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
            ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
            ->where('student_roll_number.school_id', '=', $school_id)
            ->where('student_roll_number.Year_Id', '=', $year_id)
            ->where('student_roll_number.IsDelete', '=', '0')
            ->where('student_master.IsDelete', '=', '0')
            ->orderby('student_roll_number.Roll_Number', 'asc')
            ->get();
        return view('student.view_students', compact('students', 'classes', 'RoleId', 'school_id', 'year_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];

        if($RoleId == 1)
        {
            $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;
        }else{
            $school_id =  $data['school_id'];
        }

        $classes = DB::table('class_master')->where('school_id', $school_id)->get();
        $states = DB::table('state_master')->where('IsDelete', '0')->get();
        $districts = DB::table('district_master')->where('IsDelete', '0')->get();
        $mediums = DB::table('medium_master')->get();
        return view('school.create_school',compact('classes', 'states', 'districts', 'mediums'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];

        $as = new School();
        $as->trusty_sid = $sid;
        $as->diseccode = $request->diseccode;
        $as->schoolname = $request->schoolname;
        $as->address = $request->address;
        $as->state_id = $request->state_id;
        $as->district_id = $request->district_id;
        $as->taluka_id = $request->taluka_id;
        $as->registration_no = $request->registration_no;
        $as->contact_no1 = $request->contact_no1;
        $as->email = $request->email;
        $as->school_no = $request->school_no;
        $as->device_id = $request->device_id;
        $as->year_establishment = $request->year_establishment;
        $as->MediumId = $request->MediumId;
        $as->year_establishment = $request->year_establishment;
        $as->CreatedBy = $sid;
        $as->save();
        
        $school_id = $as->id;
        
        if ($as == true)
        {
            $class_array = json_decode($request->class_array);
            foreach ($class_array as $key => $value){

                $class = explode(':', $value['class_name']);
                $class_type = $class[0];
                $class_name = $class[1];

                $cls = new SchoolClass();
                $cls->school_id = $school_id;
                $cls->ClassName = $class_name;
                $cls->class_type = $value->class_type;
                // $cls->stream = $value->stream;
                $cls->CreatedBy = $sid;
                $cls->save();
            }

            $data = array();
            $data['success'] = '1';
            $data['error'] = 'fasle';
            $data['message'] = 'Deleted Successfully';
            return json_encode($data);
        } 
        else 
        {
            $data = array();
            $data['success'] = '0';
            $data['error'] = 'true';
            $data['message'] = 'Somthing Wrong!!';
            return json_encode($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = DB::table('school_master')->where('school_id', $id)->first();
        $classes = DB::table('class_master')->where('school_id', $id)->get();
        $states = DB::table('state_master')->where('IsDelete', '0')->get();
        $districts = DB::table('district_master')->where('IsDelete', '0')->get();
        $mediums = DB::table('medium_master')->get();
        return view('school.edit_school',compact('school', 'classes', 'states', 'districts', 'mediums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // echo "Hii";exit;
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
        
        $us = School::where('school_id', $request->school_id)
                ->update(['diseccode' => $request->diseccode, 'address' => $request->address, 'schoolname' => $request->schoolname, 'state_id' => $request->state_id, 'district_id' => $request->district_id, 'taluka_id' => $request->taluka_id, 'registration_no' => $request->registration_no, 'contact_no1' => $request->contact_no1, 'contact_no2' => $request->contact_no2, 'email' => $request->email, 'school_no' => $request->school_no, 'device_id' => $request->device_id, 'year_establishment' => $request->year_establishment, 'MediumId' => $request->MediumId, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($us == true)
        {
            $class_array = json_decode($request->class_array);
            // dd($class_array);
            foreach ($class_array as $key => $value) 
            {
                $ClassName = $value->class_name;
                $is_delete = $value->is_delete;

                $ds = DB::table('class_master')->where('school_id', $request->school_id)
                    ->where('ClassName', $ClassName)
                    ->update(['IsDelete' => $is_delete, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);
            }

            $data = array();
            $data['success'] = '1';
            $data['error'] = 'fasle';
            $data['message'] = 'Updated Successfully';
            return json_encode($data);
        } 
        else 
        {
            $data = array();
            $data['success'] = '0';
            $data['error'] = 'true';
            $data['message'] = 'Somthing Wrong!!';
            return json_encode($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $ds = Student::where('school_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($ds == true)
        {
            $data = array();
            $data['success'] = '1';
            $data['error'] = 'fasle';
            $data['message'] = 'Deleted Successfully';
            return json_encode($data);
        } 
        else 
        {
            $data = array();
            $data['success'] = '0';
            $data['error'] = 'true';
            $data['message'] = 'Somthing Wrong!!';
            return json_encode($data);
        }
    }
    
    public function change_school_status(Request $request)
    {
        $scs = School::where('school_id', $request->school_id)->update(['status' => $request->status]);

        if ($scs == true)
        {
            /*$data = array();
            $data['success'] = 1;
            $data['message'] = 'Status Change Successfull.';
            return json_encode($data);*/
            return Response::json(array('success' => 1), 200);
        } 
        else 
        {
            // $data = array();
            // $data['success'] = 0;
            // $data['message'] = 'Somthing Wrong!!';
            // return json_encode($data);
            return Response::json(array('success' => 0), 200);
        }
    }

    public function selectDiv(Request $request)
    {
        $div = SchoolClassDiv::select('DivisionId', 'DivisionName')
                ->where('school_id', $request->school_id)
                ->where('ClassId', $request->class_id)
                ->get();

                // echo "Hii".$div;exit;
        if ($div == true)
        {
            $data = array();
            $data['success'] = 1;
            $data['data'] = $div;
            return json_encode($data);
        } 
        else 
        {
            $data = array();
            $data['success'] = 0;
            $data['data'] = [];
            return json_encode($data);
        }
    }

    public function selectStudentDetails(Request $request)
    {

        $data = Session::all();
        $sid = $data['sid'];

    // \DB::enableQueryLog();
        $students = StudentRollNumber::select('student_master.StudentId', 'student_roll_number.Roll_Number', 'student_master.StudentName', 'class_master.ClassName', 'division_master.DivisionName', 'student_master.GRNumber', 'student_master.ContactNumber1', 'student_master.Gender')
            ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
            ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
            ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
            ->where('student_roll_number.Current_Class', $request->class_id)
            ->where('student_roll_number.Current_Div', $request->div_id)
            ->where('student_roll_number.school_id', $request->school_id)
            ->where('student_roll_number.Year_Id', $request->year_id)
            ->where('student_roll_number.IsDelete', '=', '0')
            ->where('student_master.IsDelete', '=', '0')
            ->whereNull('student_master.lc_id')
            ->orderby('student_roll_number.Roll_Number', 'asc')
            ->get();
    // dd(\DB::getQueryLog());

        if ($students == true)
        {
            $data = array();
            $data['success'] = 1;
            $data['data'] = $students;
            return json_encode($data);
        } 
        else 
        {
            $data = array();
            $data['success'] = 0;
            $data['data'] = [];
            return json_encode($data);
        }
    }

    ////////////////////////// END Student //////////////////////////

}