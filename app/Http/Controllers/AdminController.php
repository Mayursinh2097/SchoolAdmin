<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Response;
use DB;
use Session;
use Redirect;

class AdminController extends Controller
{
    // protected $user;
    public function __construct()
    {
        // $this->middleware('auth');
    }
   
    public function index()
    {
    	return view('login');
    }


    public function doLogin(Request $request)
    {
        $rules = array(
            // 'username' => 'required|email',
            'username' => 'required',
            'password' => 'required');
        $validator = Validator::make($request->all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails())
        {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        $username = $request['username'];
        $password = $request['password'];
        $query = DB::table('user_master')
            ->where('user_master.UserName',$username)
            ->where('user_master.Password',$password)
            ->select('user_master.*')
            ->first();
        // $user=User::where('UserName','=',$username)->first();
            // $query;exit;


        if($query != null)
        {
            if($query->RollId != 1)
            {
                $school_id = $query->school_id;
                $school = DB::table('school_master')->select('schoolname')->where('school_id', '=', $query->school_id)->first();
                // session(['school_id' => $query->school_id, 'school_name' => $school->schoolname]);
                session(['school_name' => $school->schoolname]);
            }

           /* if($query->RollId == 1)
            {
                // dd($query->UserId);
                // \DB::enableQueryLog();
                	$school = DB::table('school_master')->select('school_id', 'schoolname')->where('trusty_sid', '=', $query->UserId)->first();
                // dd(\DB::getQueryLog());
                session(['school_id' => $school->school_id, 'schoolname' => $school->schoolname]);
            }*/

            $role = DB::table('role_master')->select('role')->where('id', '=', $query->RollId)->first();
            
            session(['sid' => $query->UserId, 'name' => $query->UserName, 'RoleId' => $query->RollId, 'role' => $role->role, 'photo' => $query->photo, 'school_id' => $query->school_id]);
            
            return Response::json(array('success' => true,'error_msg' => 'Login Successfully'), 200);
        }else{
            return Response::json(array('success' => false,'error_msg' => 'Invalid Username and Password'), 200);
        }

        // if($query->RollId == 1){
        //     if($password = $query->Password) 
        //     {
        //         $school_id = $query->school_id;
        //         $school = DB::table('school_master')->select('schoolname')->where('school_id', '=', $school_id)->first();

        //         session(['sid' => $query->UserId, 'name' => $query->UserName, 'school_id' => $query->school_id, 'school_name' => $school->schoolname, 'RoleId' => $query->RollId, 'photo' => $query->photo]);
        //         return Response::json(array('success' => true,'error_msg' => 'Login Successfully'), 200);
        //     }else{
        //         return Response::json(array('success' => false,'error_msg' => 'Invalid Username and Password'), 200);
        //     }
        // }else{
        //     if(password_verify($password, $query->password)) 
        //     {
        //         session(['sid' => $query->UserId, 'name' => $query->UserName, 'school_id' => $query->school_id, 'RoleId' => $query->RollId, 'photo' => $query->photo]);
        //         return Response::json(array('success' => true,'error_msg' => 'Login Successfully'), 200);
        //     }else{
        //         return Response::json(array('success' => false,'error_msg' => 'Invalid Username and Password'), 200);
        //     }
        // }
    }

    public function doLogout()
    {
        //Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

    public function userprofile()
    {

        // dd (Auth::user()) ;
        return view('userprofile');
    }


    
}
