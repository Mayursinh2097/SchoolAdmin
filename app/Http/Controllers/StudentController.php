<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\SchoolClass;
use App\Models\SchoolClassDiv;
use App\Models\Religion;

use App\Models\Student;
use App\Models\StudentRollNumber;
use App\Models\StudentLC;
use App\Models\FeeCollection;

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
            ->whereNull('student_master.lc_id')
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
                ->orderby('ClassId', 'asc')
                ->get();

        $year = DB::table('year_master')->select('YearId', 'Year')
                ->where('IsDelete', '=', '0')
                ->orderby('YearId', 'desc')
                ->first();

        $education = DB::table('education_master')
                ->select('EducationId', 'EducationName')
                ->where('IsDelete', '=', '0')
                ->orderby('EducationId', 'asc')
                ->get();

        $category = DB::table('category_master')
                ->select('CategoryId', 'CategoryName')
                ->where('IsDelete', '=', '0')
                ->orderby('CategoryId', 'asc')
                ->get();

        $religions = DB::table('religion_master')
                ->select('ReligionId', 'ReligionName')
                ->where('IsDelete', '=', '0')
                ->orderby('ReligionId', 'asc')
                ->get();

        $mediums = DB::table('medium_master')
                ->select('MediumId', 'MediumName')
                ->where('IsDelete', '=', '0')
                ->orderby('MediumId', 'asc')
                ->get();

        return view('student.create_student',compact('classes', 'year', 'education', 'category', 'religions', 'mediums', 'year_id', 'school_id'));
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

        $st = new Student();
        $st->school_id = $request->school_id;
        $st->StudentName = $request->name;
        $st->Gender = $request->gender;
        $st->dob = $request->dob;
        $st->BirthPlace = $request->birth_place;
        $st->AadharNumber = $request->aadhar_num;
        $st->Photo = $request->photo;
        $st->CategoryId = $request->category;
        $st->ReligionId = $request->religious;
        $st->FatherName = $request->father_name;
        $st->FatherEducation = $request->father_edu;
        $st->MotherName = $request->mother_name;
        $st->MothersEucation = $request->mother_edu;
        $st->FatherOccupation = $request->father_occupation;
        $st->MotherOccupation = $request->mother_occupation;
        $st->lblCaste = $request->lbl_caste;
        $st->PermenantAddress = $request->p_address;
        $st->CurrentAddress = $request->c_address;
        $st->ContactNumber1 = $request->contact1;
        $st->ContactNumber2 = $request->contact2;
        $st->acc_number = $request->acc_number;
        $st->bank_name = $request->bank_name;
        $st->bank_branch = $request->bank_branch;
        $st->AdmissionDate = $request->admission_date;
        $st->FirstAdmission = $request->first_admission;
        $st->PreviousSchoolId = $request->prev_school;
        $st->PreGRNumber = $request->prev_gr;
        $st->PreviousAttendedClassId = $request->prev_class;
        $st->ClassId = $request->admission_class;
        $st->DivisionId = $request->admission_div;
        $st->MediumId = $request->lenguage_medium;
        $st->GRNumber = $request->gr_number;
        $st->DeviceID = $request->device_id;
        $st->uid_number = $request->uid_number;
        $st->age = $request->age;
        $st->admission_year_id = $request->admission_year_id;
        $st->type_admission = $request->type_admission;
        $st->hostel_type = $request->hostel_type;
        $st->cast = $request->cast;
        $st->subcast = $request->subcast;
        $st->ifsc_code = $request->ifsc_code;
        $st->passbook_name = $request->passbook_name;
        $st->prev_result = $request->prev_result;
        $st->prev_grade = $request->prev_grade;
        $st->bpl_card_num = $request->bpl_card_num;
        $st->CreatedBy = $sid;
        $st->save();
        
        $student_id = $st->id;
        
        if ($st == true)
        {

            $srn = new StudentRollNumber();
            $srn->school_id = $request->school_id;
            $srn->Student_id = $student_id;
            $srn->Prev_Class = $request->prev_class;
            $srn->Current_Class = $request->admission_class;
            $srn->Current_Div = $request->admission_div;
            $srn->Year_Id = $request->year_id;
            $srn->created_by = $sid;
            $srn->save();

            $data = array();
            $data['success'] = '1';
            $data['error'] = 'false';
            $data['message'] = 'Inserted Successfully';
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
                ->orderby('ClassId', 'asc')
                ->get();

        $education = DB::table('education_master')
                ->select('EducationId', 'EducationName')
                ->where('IsDelete', '=', '0')
                ->orderby('EducationId', 'asc')
                ->get();

        $category = DB::table('category_master')
                ->select('CategoryId', 'CategoryName')
                ->where('IsDelete', '=', '0')
                ->orderby('CategoryId', 'asc')
                ->get();

        $religions = DB::table('religion_master')
                ->select('ReligionId', 'ReligionName')
                ->where('IsDelete', '=', '0')
                ->orderby('ReligionId', 'asc')
                ->get();

        $mediums = DB::table('medium_master')
                ->select('MediumId', 'MediumName')
                ->where('IsDelete', '=', '0')
                ->orderby('MediumId', 'asc')
                ->get();

        $students = DB::table('student_roll_number')
                ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
                ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
                ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
                ->where('StudentId', $id)->first();

        return view('student.edit_student',compact('students', 'classes', 'education', 'category', 'religions', 'mediums', 'year_id'));
    }


    public function imageUpload(Request $request)
    {
        // echo "Hii";exit;
        $croped_image = $request->image;

        list($type, $croped_image) = explode(';', $croped_image);
        list(, $croped_image)      = explode(',', $croped_image);

        $croped_image = base64_decode($croped_image);
        $image_name= time().'.png';
        $path = public_path() . "../file_upload/student/".$image_name;
        /*file_put_contents($path, $croped_image);
        return response()->json(['success'=>'done']);*/

        if (($data = @file_put_contents($path, $croped_image)) === false) 
        {
            // $response['msg'] = $error['message'];

            $data = array();
            $data['success'] = '0';
            $data['error'] = 'true';
            $data['msg'] = $error['message'];
            return json_encode($data);
        }else{
            $data = array();
            $data['success'] = '1';
            $data['error'] = 'false';
            $data['image'] = $image_name;
            return json_encode($data);

            // $data  =  array('image' => $image_name);
        }
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
        
        $sd = Student::where('StudentId', $request->id)
                ->update([
                    'StudentName' => $request->name,
                    'Gender' => $request->gender, 
                    'dob' => $request->dob, 
                    'BirthPlace' => $request->birth_place, 
                    'AadharNumber' => $request->aadhar_num, 
                    'Photo' => $request->photo, 
                    'CategoryId' => $request->category, 
                    'ReligionId' => $request->religious, 
                    'FatherName' => $request->father_name, 
                    'FatherEducation' => $request->father_edu, 
                    'MotherName' => $request->mother_name, 
                    'MothersEucation' => $request->mother_edu, 
                    'FatherOccupation' => $request->father_occupation, 
                    'MotherOccupation' => $request->mother_occupation, 
                    'lblCaste' => $request->lbl_caste, 
                    'PermenantAddress' => $request->p_address, 
                    'CurrentAddress' => $request->c_address, 
                    'ContactNumber1' => $request->contact1, 
                    'ContactNumber2' => $request->contact2, 
                    'acc_number' => $request->acc_number, 
                    'bank_name' => $request->bank_name, 
                    'bank_branch' => $request->bank_branch, 
                    'AdmissionDate' => $request->admission_date, 
                    'FirstAdmission' => $request->first_admission, 
                    'PreviousSchoolId' => $request->prev_school, 
                    'PreGRNumber' => $request->prev_gr, 
                    'PreviousAttendedClassId' => $request->prev_class, 
                    'ClassId' => $request->admission_class, 
                    'DivisionId' => $request->admission_div, 
                    'MediumId' => $request->lenguage_medium, 
                    'GRNumber' => $request->gr_number, 
                    'DeviceID' => $request->device_id, 
                    'uid_number' => $request->uid_number, 
                    'age' => $request->age, 
                    'admission_year_id' => $request->admission_year_id, 
                    'type_admission' => $request->type_admission, 
                    'hostel_type' => $request->hostel_type, 
                    'cast' => $request->cast, 
                    'subcast' => $request->subcast, 
                    'ifsc_code' => $request->ifsc_code, 
                    'passbook_name' => $request->passbook_name, 
                    'prev_result' => $request->prev_result, 
                    'prev_grade' => $request->prev_grade, 
                    'bpl_card_num' => $request->bpl_card_num,
                    'UpdatedBy' => $sid, 
                    'UpdateDTTM' => $date
                ]);

        if ($sd == true)
        {
           /* $ds = DB::table('student_roll_number')->where('Student_id', $request->id)
                ->where('Year_Id', $request->year_id)
                ->update([
                    'Prev_Class' => $request->prev_class, 
                    'Current_Class' => $request->admission_class,  
                    'Current_Div' => $request->admission_div,  
                    'UpdatedBy' => $sid, 
                    'UpdatedAt' => $date
                ]);*/

            $data = array();
            $data['success'] = '1';
            $data['error'] = 'false';
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
        $year_id = $_COOKIE['year'];
    
        $ds = Student::where('StudentId', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($ds == true)
        {
            $dsn = StudentRollNumber::where('Student_id', $request->id)
                ->where('Year_Id', $year_id)
                ->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdatedAt' => $date]);
            $data = array();
            $data['success'] = '1';
            $data['error'] = '';
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
    
    public function selectDiv(Request $request)
    {
        $div = SchoolClassDiv::select('DivisionId', 'DivisionName')
                // ->where('school_id', $request->school_id)
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


    ////////////////////////// Student RollNumber//////////////////////////

    public function rollNumber()
    {
        $data = Session::all();
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

        $students = Student::select('student_roll_number.Roll_Number', 'student_master.StudentName', 'student_master.StudentId', 'student_roll_number.Current_Class', 'student_roll_number.Current_Div')
            ->join('student_roll_number', 'student_roll_number.Student_id', '=', 'student_master.StudentId')
            ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
            ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
            ->where('student_roll_number.school_id', '=', $school_id)
            ->where('student_roll_number.Year_Id', '=', $year_id)
            ->where('student_roll_number.IsDelete', '=', '0')
            ->where('student_master.IsDelete', '=', '0')
            ->whereNull('student_master.lc_id')
            ->orderby('student_roll_number.Roll_Number', 'asc')
            ->get();

        return view('student.roll_number', compact('students', 'classes', 'RoleId', 'school_id', 'year_id'));
    }

    public function getStudents(Request $request)
    {

        $data = Session::all();
        $sid = $data['sid'];

        $students = StudentRollNumber::select('student_master.StudentId', 'student_roll_number.Roll_Number', 'student_master.StudentName', 'student_roll_number.Current_Class', 'student_roll_number.Current_Div')
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

    public function saveStudentRollNumber(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];
        $date = date('Y-m-d H:i:s');

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        $student = StudentRollNumber::where('Roll_Number', $request->edit_num)
                ->Where('Current_Class', $request->edit_class)
                ->Where('Current_Div', $request->edit_div)
                ->Where('Year_Id', $request->year_id)
                ->where('IsDelete', '=', '0')
                ->first();

        if($student == true)
        {
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Roll Number is already exist';
            return json_encode($data);                              
        }
        else 
        {
            $sc = StudentRollNumber::where('Student_id', $request->no)
                ->where('Year_Id', $request->year_id)
                ->update(['Roll_Number' => $request->edit_num, 'UpdatedBy' => $sid, 'UpdatedAt' => $date]); 

            if ($sc == true) 
            {
                $st_roll = Student::select('RollNumber')
                    ->where('StudentId', $request->no)
                    ->where('IsDelete', '=', '0')
                    ->first();

                if ($st_roll->RollNumber == null) 
                {
                    $sc = Student::where('StudentId', $request->no)
                        ->update(['RollNumber' => $request->edit_num, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);
                    $data = array();
                    $data['success'] = '1';
                    $data['error'] = 'false';
                    $data['message'] = 'Updated Successfully';
                    return json_encode($data);     
                }else{
                    $data = array();
                    $data['success'] = '1';
                    $data['error'] = 'false';
                    $data['message'] = 'Updated Successfully';
                    return json_encode($data);      
                }                            
            }
            else 
            {
                $data['success'] = '0';
                $data['error'] = 'true';
                $data['message'] = 'Somthing Wrong!!';
                return json_encode($data);
            }
        }
    }

    ////////////////////////// END Student RollNumber//////////////////////////

    ////////////////////////// Student LC//////////////////////////

    public function viewStudents()
    {
        $data = Session::all();
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

        $students = Student::select('student_roll_number.Roll_Number', 'student_master.StudentName', 'student_master.StudentId', 'student_roll_number.Current_Class', 'student_roll_number.Current_Div')
            ->join('student_roll_number', 'student_roll_number.Student_id', '=', 'student_master.StudentId')
            ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
            ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
            ->where('student_roll_number.school_id', '=', $school_id)
            ->where('student_roll_number.Year_Id', '=', $year_id)
            ->where('student_roll_number.IsDelete', '=', '0')
            ->where('student_master.IsDelete', '=', '0')
            ->whereNull('student_master.lc_id')
            ->orderby('student_roll_number.Roll_Number', 'asc')
            ->get();

        return view('student.student_lc', compact('students', 'classes', 'RoleId', 'school_id', 'year_id'));
    }

    public function getStudentsList(Request $request)
    {

        $data = Session::all();
        $sid = $data['sid'];

        $students = StudentRollNumber::select('student_master.StudentId', 'student_roll_number.Roll_Number', 'student_master.StudentName', 'student_roll_number.Current_Class', 'student_roll_number.Current_Div')
            ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
            ->join('class_master', 'class_master.CLassId', '=', 'student_roll_number.Current_Class')
            ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
            ->where('student_roll_number.Current_Class', $request->class_id)
            ->where('student_roll_number.Current_Div', $request->div_id)
            ->where('student_roll_number.school_id', $request->school_id)
            ->where('student_roll_number.Year_Id', $request->year_id)
            ->where('student_roll_number.IsDelete', '=', '0')
            ->where('student_master.IsDelete', '=', '0')
            ->WhereNotNull('student_roll_number.Roll_Number')
            ->whereNull('student_master.lc_id')
            ->orderby('student_roll_number.Roll_Number', 'asc')
            ->get();

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

    public function addStudentLC(Request $request, $id)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        $studentName = $request->name;
        $class_id = $request->cid;
        $student_id = $id;
        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        return view('student.add_student_lc',compact('RoleId','school_id', 'year_id', 'studentName', 'class_id', 'student_id'));
    }


    public function addStudLC(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        $date = date('Y-m-d H:i:s');


        $st = StudentLC::where('student_id', $request->id)
                ->where('IsDelete', '=', '0')
                ->first();

        if ($st == false)
        {
            $sl = new StudentLC();
            $sl->student_id = $request->id;
            $sl->Year_Id = $request->year_id;
            $sl->lc_number = $request->lc_number;
            $sl->progress = NULL;
            $sl->conduct = NULL;
            $sl->attendance = NULL;
            $sl->date_of_leaving = $request->date_of_leaving;
            $sl->remark = $request->remark;
            $sl->class_at_leaving = $request->class_at_leaving;
            $sl->reason_of_leaving = $request->reason_of_leaving;
            $sl->CreatedBy = $sid;
            $sl->save();

            $lc_id = $sl->id;
                    
            if ($sl == true)
            {
                $sd = Student::where('StudentId', $request->id)
                        ->update(['lc_id' => $lc_id, 'IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

                $srn = StudentRollNumber::where('Student_id', $request->id)
                        ->where('Year_Id', $request->year_id)
                        ->update(['lc_id' => $lc_id, 'IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdatedAt' => $date]);

                $fc = FeeCollection::where('student_id', $request->id)
                        ->where('Year_Id', $request->year_id)
                        ->update(['IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);
                
                $data = array();
                $data['success'] = '1';
                $data['error'] = 'fasle';
                $data['message'] = 'Inserted Successfully';
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
        }else{

            $sd = StudentLC::where('Student_id', $request->id)
                        ->where('Year_Id', $request->year_id)
                        ->update(['lc_number' => $lc_number, 'progress' => NULL, 'conduct' => NULL, 'attendance' => NULL, 'date_of_leaving' => $request->date_of_leaving, 'remark' => $request->remark, 'class_at_leaving' => $request->class_at_leaving, 'reason_of_leaving' => $request->reason_of_leaving, 'UpdatedBy' => $sid, 'updated_at' => $date]);
            if ($sl == true)
            {

                $sd = Student::where('StudentId', $request->id)
                        ->update(['lc_id' => $lc_id, 'IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

                $srn = StudentRollNumber::where('Student_id', $request->id)
                        ->where('Year_Id', $request->year_id)
                        ->update(['lc_id' => $lc_id, 'IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdatedAt' => $date]);

                $fc = FeeCollection::where('student_id', $request->id)
                        ->where('Year_Id', $request->year_id)
                        ->update(['IsDelete' => 1, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

                $data = array();
                $data['success'] = '1';
                $data['error'] = 'false';
                $data['message'] = 'Updated Successfully';
                return json_encode($data);
            }else{
                $data = array();
                $data['success'] = '0';
                $data['error'] = 'true';
                $data['message'] = 'Somthing Wrong!!';
                return json_encode($data);
            }
        }
    }

    ////////////////////////// END Student LC//////////////////////////

}