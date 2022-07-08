<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\StudentRollNumber;
use App\Models\Category;
use App\Models\FeeCollection;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use \Input;
use DB;
use Session;
use Response;
use Redirect;

class FeesController extends Controller
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

    ////////////////////////// Category //////////////////////////

    public function viewCategory()
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        $categorys = Category::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('fee_category_id', 'asc')
            ->get();
        return view('fees.fees_category', compact('categorys', 'sid', 'RoleId', 'school_id', 'year_id'));
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

    public function viewTeacher(Request $request)
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }
// \DB::enableQueryLog();
        $teachers = User::join('role_master', 'role_master.id', '=', 'user_master.RollId')
            ->where('UserId', '!=', $sid)
            ->where('RollId', '!=', '1')
            ->Where('Name', 'like', '%' . $request->tname . '%')
            ->where('school_id', '=', $school_id)
            ->where('user_master.IsDelete', '=', '0')
            ->orderby('user_master.RollId', 'asc')
            ->get();
        // dd(\DB::getQueryLog());
        // var_dump($teachers);exit;

        if ($teachers == true)
        {
            $data = array();
            $data['success'] = '1';
            $data['error'] = 'false';
            $data['data'] = $teachers;
            return json_encode($data);
        }

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        $cg = new Category();
        $cg->school_id = $request->school_id;
        $cg->fee_category_name = $request->fee_category;
        $cg->receipt_prefix = $request->receipt_no;
        $cg->description = $request->description;
        $cg->CreatedBy = $sid;
        $cg->save();
        
        $student_id = $cg->id;
        
        if ($cg == true)
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

    public function deleteCategory(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $du =  Category::where('fee_category_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($du == true)
        {
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
    ////////////////////////// Category //////////////////////////
}
?>