<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolClassDiv;

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

    ////////////////////////// Division //////////////////////////
}