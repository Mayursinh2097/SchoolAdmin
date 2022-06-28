<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Response;
use DB;
use Session;
use Redirect;

class SchoolController extends Controller
{
    // protected $user;
    public function __construct()
    {
        // $this->middleware('auth');
    }
   
    public function index(Request $request)
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

    public function change_school_status(Request $request)
    {
        $UpdateschoolDetails = School::where('school_id', $request->school_id)->update(['status' => $request->status]);

        if ($UpdateschoolDetails == true)
        {
            return Response::json(array('success' => 1), 200);
        } 
        else 
        {
            return Response::json(array('success' => 0), 200);
        }  
    }

    public function edit_school($id)
    {
        $school = DB::table('school_master')->where('school_id', $id)->first();
        $classes = DB::table('class_master')->where('school_id', $id)->get();
        $states = DB::table('state_master')->where('IsDelete', '0')->get();
        $districts = DB::table('district_master')->where('IsDelete', '0')->get();
        $mediums = DB::table('medium_master')->get();
        return view('school.edit_school',compact('school', 'classes', 'states', 'districts', 'mediums'));
    }

    public function deleteschool(Request $request)
    {
        // \DB::enableQueryLog();
            $Deleteschool = School::where('school_id', $request->id)->update(['IsDelete' => '1']);
        // dd(\DB::getQueryLog());

        if ($Deleteschool == true)
        {
            return Response::json(array('success' => 1), 200);
        } 
        else 
        {
            return Response::json(array('success' => 0), 200);
        }  
    }
}