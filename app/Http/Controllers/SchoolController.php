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
use App\Models\SchoolHoliday;
use App\Models\SubjectMaster;
use App\Models\LectureTime;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use \Input;
use DB;
use Session;
use Response;
use Redirect;

class SchoolController extends Controller
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

    ////////////////////////// SChool //////////////////////////
    public function index()
    {
        $data = Session::all();
        $sid =  $data['sid'];

        $Schools = School::select('school_master.school_id', 'school_master.schoolname', 'school_master.diseccode', 'school_master.registration_no', 'school_master.contact_no1', 'school_master.email', 'school_master.standard', 'school_master.status', 'medium_master.MediumName')
            ->join('medium_master', 'medium_master.MediumId', '=', 'school_master.MediumId')
            ->where('school_master.IsDelete', '=', '0')
            ->where('medium_master.IsDelete', '=', '0')
            ->where('school_master.trusty_sid', '=', $sid)
            ->orderby('school_master.school_id', 'asc')
            ->get();
        return view('school.view_school', compact('Schools'));
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
    
        $ds = School::where('school_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

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
    ////////////////////////// END SChool //////////////////////////

    ////////////////////////// Class //////////////////////////

    public function viewClass()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();
        return view('school.class', compact('classes', 'school_id', 'year_id'));
    }

    public function addClass(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        // \DB::enableQueryLog();
        $class = SchoolClass::where('school_id', $request->school_id)
                ->Where('class_type', 'like', '%' . $request->class_type . '%')
                ->Where('ClassName', 'like', '%' . $request->ClassName . '%')
                ->Where('stream', $request->stream)
                ->where('IsDelete', '=', '0')
                ->first();

        // dd(\DB::getQueryLog());
        if($class == false)
        {
            $cl = new SchoolClass();
            $cl->class_type = $request->class_type;
            $cl->ClassName = $request->ClassName;
            $cl->school_id = $request->school_id;
            $cl->stream = $request->stream;
            $cl->CreatedBy = $sid;
            $cl->save();
            
            if ($cl == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Class is already exist';
            return json_encode($data);
        }
    }

    public function editClass($id)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $classes = SchoolClass::where('ClassId', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();
        return view('school.edit_class',compact('classes', 'school_id', 'year_id'));
    }

    public function updateClass(Request $request)
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

        $class = SchoolClass::where('school_id', $request->school_id)
                ->Where('class_type', $request->class_type)
                ->Where('ClassName', $request->ClassName)
                ->Where('stream', $request->stream)
                ->where('IsDelete', '=', '0')
                ->first();
        if($class == false)
        {
            $sc = SchoolClass::where('ClassId', $request->ClassId)
                    ->update(['class_type' => $request->class_type, 'ClassName' => $request->ClassName, 'stream' => $request->stream, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($sc == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Class is already exist';
            return json_encode($data);
        }
    }

    public function deleteClass(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $dsc = SchoolClass::where('ClassId', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dsc == true)
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

    ////////////////////////// END Class //////////////////////////


    ////////////////////////// Division //////////////////////////

    public function viewDivision()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();

        $division = SchoolClassDiv::select('division_master.*', 'ClassName')
            ->join('class_master', 'class_master.ClassId', '=', 'division_master.ClassId')
            ->where('division_master.school_id', '=', $school_id)
            ->where('division_master.IsDelete', '=', '0')
            ->orderby('division_master.ClassId', 'asc')
            ->get();

        return view('school.division', compact('division', 'classes', 'school_id', 'year_id'));
    }

    public function addDivision(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        // \DB::enableQueryLog();

        $division = SchoolClassDiv::where('school_id', $request->school_id)
                ->Where('ClassId', $request->ClassId)
                ->Where('DivisionName', 'like', '%' . $request->DivisionName . '%')
                ->where('IsDelete', '=', '0')
                ->first();

        // dd(\DB::getQueryLog());
        if($division == false)
        {
            $cl = new SchoolClassDiv();
            $cl->ClassId = $request->ClassId;
            $cl->DivisionName = $request->DivisionName;
            $cl->school_id = $request->school_id;
            $cl->CreatedBy = $sid;
            $cl->save();
            
            if ($cl == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Division is already exist';
            return json_encode($data);
        }
    }

    public function editDivision($id)
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

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();

        $division = SchoolClassDiv::where('DivisionId', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('school.edit_division',compact('division', 'classes', 'school_id', 'year_id'));
    }

    public function updateDivision(Request $request)
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

        $division = SchoolClassDiv::where('school_id', $request->school_id)
                ->Where('ClassId', $request->ClassId)
                ->Where('DivisionName', $request->DivisionName)
                ->where('IsDelete', '=', '0')
                ->first();

        if($division == false)
        {
        
            $scd = SchoolClassDiv::where('DivisionId', $request->DivisionId)
                    ->update(['ClassId' => $request->ClassId, 'DivisionName' => $request->DivisionName, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($scd == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Division is already exist';
            return json_encode($data);
        }
    }

    public function deleteDivision(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $dcd = SchoolClassDiv::where('DivisionId', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dcd == true)
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

    ////////////////////////// End Division //////////////////////////

    ////////////////////////// State //////////////////////////

    public function viewState()
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

        $states = State::select('state_master.*')
            ->where('IsDelete', '=', '0')
            ->orderby('state_id', 'asc')
            ->get();

        return view('school.state', compact('states', 'school_id', 'year_id'));
    }

    public function addState(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        // \DB::enableQueryLog();

        $state = State::Where('state_name', 'like', '%' . $request->state_name . '%')
                ->where('IsDelete', '=', '0')
                ->first();

        // dd(\DB::getQueryLog());
        if($state == false)
        {
            $st = new State();
            $st->state_name = $request->state_name;
            $st->CreatedBy = $sid;
            $st->save();
            
            if ($st == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'State is already exist';
            return json_encode($data);
        }
    }

    public function editState($id)
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

        $state = State::where('state_id', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('school.edit_state',compact('state', 'school_id', 'year_id'));
    }

    public function updateState(Request $request)
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

        $state = State::Where('state_name', $request->state_name)->where('IsDelete', '=', '0')->first();
        if($state == false)
        {
            $st = State::where('state_id', $request->state_id)
                    ->update(['state_name' => $request->state_name, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($st == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'State is already exist';
            return json_encode($data);
        }
    }

    public function deleteState(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $ds = State::where('state_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

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

    ////////////////////////// END State //////////////////////////

    ////////////////////////// District //////////////////////////

    public function viewDistrict()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $states = State::where('IsDelete', '=', '0')
            ->orderby('state_id', 'asc')
            ->get();

        $districts = District::select('district_master.*', 'state_name')
            ->join('state_master', 'state_master.state_id', '=', 'district_master.state_id')
            ->where('district_master.IsDelete', '=', '0')
            ->orderby('district_master.state_id', 'asc')
            ->get();

        return view('school.district', compact('districts', 'states', 'school_id', 'year_id'));
    }

    public function addDistrict(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];

        $district = District::Where('state_id', $request->state_id)
                ->Where('district_name', $request->district_name)
                ->where('IsDelete', '=', '0')
                ->first();
        if($district == false)
        {
            $cl = new District();
            $cl->state_id = $request->state_id;
            $cl->district_name = $request->district_name;
            $cl->CreatedBy = $sid;
            $cl->save();
            
            if ($cl == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'District is already exist';
            return json_encode($data);
        }
    }

    public function editDistrict($id)
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

        $states = State::where('IsDelete', '=', '0')
            ->orderby('state_id', 'asc')
            ->get();

        $district = District::where('district_id', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('school.edit_district',compact('district', 'states', 'school_id', 'year_id'));
    }

    public function updateDistrict(Request $request)
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

        $district = District::Where('state_id', $request->state_id)
                ->Where('district_name', $request->district_name)
                ->where('IsDelete', '=', '0')
                ->first();

        if($district == false)
        {
        
            $ds = District::where('district_id', $request->district_id)
                    ->update(['state_id' => $request->state_id, 'district_name' => $request->district_name, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($ds == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'District is already exist';
            return json_encode($data);
        }
    }

    public function deleteDistrict(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $dcd = District::where('district_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dcd == true)
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

    ////////////////////////// End District //////////////////////////

    ////////////////////////// Religion //////////////////////////

    public function viewReligion()
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

        $religions = Religion::select('religion_master.*')
            ->where('IsDelete', '=', '0')
            ->orderby('ReligionId', 'asc')
            ->get();

        return view('school.religion', compact('religions', 'school_id', 'year_id'));
    }

    public function addReligion(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];

        $religion = Religion::Where('ReligionName', $request->ReligionName)
                ->where('IsDelete', '=', '0')
                ->first();

        if($religion == false)
        {
            $rg = new Religion();
            $rg->ReligionName = $request->ReligionName;
            $rg->CreatedBy = $sid;
            $rg->save();
            
            if ($rg == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Religion is already exist';
            return json_encode($data);
        }
    }

    public function editReligion($id)
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

        $religion = Religion::where('ReligionId', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('school.edit_religion',compact('religion', 'school_id', 'year_id'));
    }

    public function updateReligion(Request $request)
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

        $religion = Religion::Where('ReligionName', $request->ReligionName)->where('IsDelete', '=', '0')->first();
        if($religion == false)
        {
            $rg = Religion::where('ReligionId', $request->ReligionId)
                    ->update(['ReligionName' => $request->ReligionName, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($rg == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Religion is already exist';
            return json_encode($data);
        }
    }

    public function deleteReligion(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $rg = Religion::where('ReligionId', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($rg == true)
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

    ////////////////////////// END Religion //////////////////////////

    ////////////////////////// Subject //////////////////////////

    public function viewSubject()
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

        $subjects = Subject::select('subject.*')
            ->where('school_id', '=', $school_id)
            ->where('is_delete', '=', '0')
            ->orderby('id', 'asc')
            ->get();

        return view('school.subject', compact('subjects', 'school_id', 'year_id'));
    }

    public function addSubject(Request $request) 
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];

        if($RoleId == 1)
        {
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
        }

        $religion = Subject::Where('subject', $request->subject)
                ->where('school_id', '=', $school_id)
                ->where('is_delete', '=', '0')
                ->first();

        if($religion == false)
        {
            $rg = new Subject();
            $rg->subject = $request->subject;
            $rg->school_id = $school_id;
            $rg->save();
            
            if ($rg == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Subject is already exist';
            return json_encode($data);
        }
    }

    public function editSubject($id)
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

        $subjects = Subject::where('id', '=', $id)
            ->where('school_id', '=', $school_id)
            ->where('is_delete', '=', '0')
            ->first();

        return view('school.edit_subject',compact('subjects', 'school_id', 'year_id'));
    }

    public function updateSubject(Request $request)
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

        $subject = Subject::Where('subject', $request->subject)->where('school_id', '=', $school_id)->where('is_delete', '=', '0')->first();
        if($subject == false)
        {
            $sb = Subject::where('id', $request->id)
                    ->update(['subject' => $request->subject]);

            if ($sb == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Subject is already exist';
            return json_encode($data);
        }
    }

    public function deleteSubject(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $rg = Subject::where('id', $request->id)->update(['is_delete' => '1']);

        if ($rg == true)
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

    ////////////////////////// END Subject //////////////////////////


    ////////////////////////// School Holiday //////////////////////////

    public function viewSchoolHoliday()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];

        $year_id = $_COOKIE['year'];
        // echo $year_id;exit;

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $schoolHolidays = SchoolHoliday::select('holiday_master.*')
            ->where('school_id', '=', $school_id)
            ->where('year_id', '=', $year_id)
            ->where('is_delete', '=', '0')
            ->orderby('holiday_id', 'asc')
            ->get();

        return view('school.school_holiday', compact('schoolHolidays', 'school_id', 'year_id'));
    }

    public function addSchoolHoliday(Request $request) 
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

        $schoolHoliday = SchoolHoliday::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('holiday_date', $request->holiday_date)
                ->Where('holiday_name', $request->holiday_name)
                ->where('is_delete', '=', '0')
                ->first();

        if($schoolHoliday == false)
        {
            $sh = new SchoolHoliday();
            $sh->holiday_date = $request->holiday_date;
            $sh->holiday_name = $request->holiday_name;
            $sh->school_id = $school_id;
            $sh->year_id = $year_id;
            $sh->save();
            
            if ($sh == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'School Holiday Date is already exist';
            return json_encode($data);
        }
    }

    public function editSchoolHoliday($id)
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

        $holidays = SchoolHoliday::where('holiday_id', '=', $id)
            ->where('is_delete', '=', '0')
            ->first();

        return view('school.edit_school_holiday',compact('holidays', 'school_id', 'year_id'));
    }

    public function updateSchoolHoliday(Request $request)
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

        $schoolHoliday = SchoolHoliday::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('holiday_date', $request->holiday_date)
                ->Where('holiday_name', $request->holiday_name)
                ->where('is_delete', '=', '0')
                ->first();

        if($schoolHoliday == false)
        {
        
            $sh = SchoolHoliday::where('holiday_id', $request->holiday_id)
                    ->update(['holiday_date' => $request->holiday_date, 'holiday_name' => $request->holiday_name]);

            if ($sh == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'School Holiday is already exist';
            return json_encode($data);
        }
    }

    public function deleteSchoolHoliday(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
    
        $dcd = SchoolHoliday::where('holiday_id', $request->id)->update(['is_delete' => '1']);

        if ($dcd == true)
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

    ////////////////////////// End School Holiday //////////////////////////


    ////////////////////////// Class Subject Allocation //////////////////////////

    public function viewClassSubject()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $subjects = Subject::where('school_id', '=', $school_id)
            ->where('is_delete', '=', '0')
            ->orderby('id', 'asc')
            ->get();

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();
// \DB::enableQueryLog();

        $subjectMaster = SubjectMaster::select('subject_master.*', 'class_master.ClassName', 'subject.subject')
            ->join('class_master', 'class_master.ClassId', '=', 'subject_master.ClassId')
            ->join('subject', 'subject.id', '=', 'subject_master.SubjectName')
            ->where('subject_master.school_id', '=', $school_id)
            ->where('subject_master.year_id', '=', $year_id)
            ->where('subject_master.IsDelete', '=', '0')
            ->orderby('subject_master.ClassId', 'asc')
            ->get();
// dd(\DB::getQueryLog());

        return view('school.class_subject', compact('subjectMaster', 'classes', 'subjects', 'school_id', 'year_id'));
    }

    public function addClassSubject(Request $request) 
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

         $subjectMaster = SubjectMaster::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('ClassId', $request->ClassId)
                ->Where('SubjectName', $request->SubjectName)
                ->where('IsDelete', '=', '0')
                ->first();

        if($subjectMaster == false)
        {
            $sm = new SubjectMaster();
            $sm->ClassId = $request->ClassId;
            $sm->SubjectName = $request->SubjectName;
            $sm->school_id = $request->school_id;
            $sm->year_id = $request->year_id;
            $sm->CreatedBy = $sid;
            $sm->save();
            
            if ($sm == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Subject is already exist';
            return json_encode($data);
        }
    }

    public function editClassSubject($id)
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

        $subjects = Subject::where('school_id', '=', $school_id)
            ->where('is_delete', '=', '0')
            ->orderby('id', 'asc')
            ->get();

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();

        $subjectMaster = SubjectMaster::where('SubjectId', '=', $id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('school.edit_class_subject',compact('subjectMaster', 'classes', 'subjects', 'school_id', 'year_id'));
    }

    public function updateClassSubject(Request $request)
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

        $subjectMaster = SubjectMaster::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('ClassId', $request->ClassId)
                ->Where('SubjectName', $request->SubjectName)
                ->where('IsDelete', '=', '0')
                ->first();

        if($subjectMaster == false)
        {
        
            $sm = SubjectMaster::where('SubjectId', $request->SubjectId)
                    ->update(['ClassId' => $request->ClassId, 'SubjectName' => $request->SubjectName, 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

            if ($sm == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Subject is already exist';
            return json_encode($data);
        }
    }

    public function deleteClassSubject(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $dcd = SubjectMaster::where('SubjectId', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dcd == true)
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

    ////////////////////////// End Class Subject Allocation //////////////////////////


    ////////////////////////// Lecture //////////////////////////

    public function viewLecture()
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
           /* $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;*/
            $school_id = $_COOKIE['user'];
        }else{
            $school_id =  $data['school_id'];
            // echo "HiiElse".$school_id;exit;
        }

        $days = DB::table('day_master')
            ->where('is_delete', '=', '0')
            ->orderby('day_id', 'asc')
            ->get();

        $lectures = LectureTime::select('lecture_time.*', 'day')
            ->join('day_master', 'day_master.day_id', '=', 'lecture_time.day_id')
            ->where('school_id', '=', $school_id)
            ->where('year_id', '=', $year_id)
            ->where('lecture_time.is_delete', '=', '0')
            ->orderby('lecture_id', 'asc')
            ->get();

        return view('school.lecture', compact('lectures', 'days', 'school_id', 'year_id'));
    }

    public function addLecture(Request $request) 
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

        $lecture = LectureTime::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('day_id', $request->day_id)
                ->Where('lecture_name', $request->lecture_name)
                ->where('is_delete', '=', '0')
                ->first();

        if($lecture == false)
        {
            $lt = new LectureTime();
            $lt->day_id = $request->day_id;
            $lt->lecture_name = $request->lecture_name;
            $lt->start_time = $request->start_time;
            $lt->end_time = $request->end_time;
            $lt->school_id = $request->school_id;
            $lt->year_id = $request->year_id;
            $lt->save();
            
            if ($lt == true)
            {
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
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Lecture is already exist';
            return json_encode($data);
        }
    }

    public function editLecture($id)
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

        $days = DB::table('day_master')
            ->where('is_delete', '=', '0')
            ->orderby('day_id', 'asc')
            ->get();

        $lecture = LectureTime::where('lecture_id', '=', $id)
            ->where('is_delete', '=', '0')
            ->first();

        return view('school.edit_lecture',compact('lecture', 'days', 'school_id', 'year_id'));
    }

    public function updateLecture(Request $request)
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

        $lecture = LectureTime::where('school_id', $request->school_id)
                ->Where('year_id', $request->year_id)
                ->Where('day_id', $request->day_id)
                ->Where('lecture_name', $request->lecture_name)
                ->Where('start_time', $request->start_time)
                ->Where('end_time', $request->end_time)
                ->where('is_delete', '=', '0')
                ->first();

        if($lecture == false)
        {
        
            $lt = LectureTime::where('lecture_id', $request->lecture_id)
                    ->update(['day_id' => $request->day_id, 'lecture_name' => $request->lecture_name, 'start_time' => $request->start_time, 'end_time' => $request->end_time]);

            if ($lt == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Lecture is already exist';
            return json_encode($data);
        }
    }

    public function deleteLecture(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
    
        $lt = LectureTime::where('lecture_id', $request->id)->update(['is_delete' => '1']);

        if ($lt == true)
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

    ////////////////////////// End Lecture //////////////////////////

}