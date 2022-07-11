<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\StudentRollNumber;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FeeDates;
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
            ->where('year_id', '=', $year_id)
            ->where('IsDelete', '=', '0')
            ->orderby('fee_category_id', 'asc')
            ->get();
        return view('fees.fees_category', compact('categorys', 'sid', 'RoleId', 'school_id', 'year_id'));
    }

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

        $category = Category::where('school_id', '=', $request->school_id)
                ->where('year_id', '=', $request->year_id)
                ->where('fee_category_name', '=', $request->fee_category)
                ->where('receipt_prefix', '=', $request->receipt_no)
                ->where('IsDelete', '=', '0')
                ->first();
        if ($category == false)
        {
            $cg = new Category();
            $cg->school_id = $request->school_id;
            $cg->year_id = $request->year_id;
            $cg->fee_category_name = $request->fee_category;
            $cg->receipt_prefix = $request->receipt_no;
            $cg->description = $request->description;
            $cg->CreatedBy = $sid;
            $cg->save();

            if ($cg == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Category is already exist';
            return json_encode($data);
        }
       
    }

    public function editCategory($id)
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

        $categorys = Category::where('fee_category_id', $id)->first();

        return view('fees.edit_fees_category',compact('categorys', 'school_id', 'year_id'));
    }

    public function updateCategory(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');

        $category = Category::where('school_id', '=', $request->school_id)
                ->where('year_id', '=', $request->year_id)
                ->where('fee_category_name', '=', $request->fee_category)
                ->where('receipt_prefix', '=', $request->receipt_no)
                ->where('IsDelete', '=', '0')
                ->first();

        if($category == false)
        {
            $cg = Category::where('fee_category_id', $request->fee_category_id)
                    ->update([
                        'fee_category_name' => $request->fee_category,
                        'receipt_prefix' => $request->receipt_no,
                        'description' => $request->description,
                        'UpdatedBy' => $sid,
                        'UpdateDTTM' => $date
                    ]);

            if ($cg == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Category is already exist';
            return json_encode($data);
        }
    }

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
    ////////////////////////// ENd Category //////////////////////////

    ////////////////////////// SubCategory //////////////////////////

    public function viewSubCategory()
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

         /*$subcategorys = SubCategory::where('school_id', '=', $school_id)
            ->where('YearId', '=', $year_id)
            ->where('IsDelete', '=', '0')
            ->orderby('fee_subcategory_id', 'asc')
            ->get();*/

         $subcategorys = SubCategory::select('fee_subcategory_id', 'fee_subcategory_name', 'amount', 'fees_category.fee_category_name')
            ->join('fees_category', 'fees_category.fee_category_id', '=', 'fees_subcategory.fee_category_id')
            ->where('fees_subcategory.school_id', '=', $school_id)
            ->where('YearId', '=', $year_id)
            ->where('fees_subcategory.IsDelete', '=', '0')
            ->orderby('fee_subcategory_id', 'asc')
            ->get();
        return view('fees.fees_subcategory', compact('subcategorys', 'sid', 'RoleId', 'school_id', 'year_id'));
    }

    public function createSubCategory()
    {
        $data = Session::all();
        $sid = $data['sid'];
        $RoleId = $data['RoleId'];
        $year_id = $_COOKIE['year'];

        if($RoleId == 1)
        {
            $school = DB::table('school_master')->where('trusty_sid', $sid)->first();
            $school_id = $school->school_id;
        }else{
            $school_id =  $data['school_id'];
        }

        $categorys = Category::where('school_id', $school_id)->get();
        return view('fees.create_fees_subcategory',compact('categorys', 'school_id', 'year_id'));
    }

    public function addSubCategory(Request $request)
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

        $sc = new SubCategory();
        $sc->school_id = $request->school_id;
        $sc->YearId = $request->year_id;
        $sc->fee_category_id = $request->fee_category_id;
        $sc->fee_subcategory_name = $request->fee_subcategory_name;
        $sc->amount = $request->amount;
        $sc->fee_type = $request->fee_type;
        $sc->CreatedBy = $sid;
        $sc->save();

        $fee_subcategory_id = $sc->id;

        if ($sc == true)
        {
            if($request->fee_type == 1)
            {
                $data = ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date1, 'due_date'=> $request->due_date1, 'end_date'=> $request->end_date1, 'installment_amount'=> $request->amount];

                $fd = FeeDates::insert($data);

            }else if($request->fee_type == 2)
            {
                $data = [ 
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date1, 'due_date'=> $request->due_date1, 'end_date'=> $request->end_date1, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date2, 'due_date'=> $request->due_date2, 'end_date'=> $request->end_date2, 'installment_amount'=> $request->amount]
                ];

                $fd = FeeDates::insert($data);

            }else if($request->fee_type == 3)
            {
                $data = [ 
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date1, 'due_date'=> $request->due_date1, 'end_date'=> $request->end_date1, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date3, 'due_date'=> $request->due_date3, 'end_date'=> $request->end_date3, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date4, 'due_date'=> $request->due_date4, 'end_date'=> $request->end_date4, 'installment_amount'=> $request->amount]
                ];

                $fd = FeeDates::insert($data);

            }else if($request->fee_type == 4)
            {
                $data = [ 
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date1, 'due_date'=> $request->due_date1, 'end_date'=> $request->end_date1, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date2, 'due_date'=> $request->due_date2, 'end_date'=> $request->end_date2, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date3, 'due_date'=> $request->due_date3, 'end_date'=> $request->end_date3, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date4, 'due_date'=> $request->due_date4, 'end_date'=> $request->end_date4, 'installment_amount'=> $request->amount]
                ];

                $fd = FeeDates::insert($data);

            }else{ 

                $data = [ 
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date1, 'due_date'=> $request->due_date1, 'end_date'=> $request->end_date1, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date2, 'due_date'=> $request->due_date2, 'end_date'=> $request->end_date2, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date3, 'due_date'=> $request->due_date3, 'end_date'=> $request->end_date3, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date4, 'due_date'=> $request->due_date4, 'end_date'=> $request->end_date4, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date5, 'due_date'=> $request->due_date5, 'end_date'=> $request->end_date5, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date6, 'due_date'=> $request->due_date6, 'end_date'=> $request->end_date6, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date7, 'due_date'=> $request->due_date7, 'end_date'=> $request->end_date7, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date8, 'due_date'=> $request->due_date8, 'end_date'=> $request->end_date8, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date9, 'due_date'=> $request->due_date9, 'end_date'=> $request->end_date9, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date10, 'due_date'=> $request->due_date10, 'end_date'=> $request->end_date10, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date11, 'due_date'=> $request->due_date11, 'end_date'=> $request->end_date11, 'installment_amount'=> $request->amount],
                    ['school_id'=> $request->school_id, 'fee_type_id'=> $fee_subcategory_id, 'fee_type'=> $request->fee_type, 'start_date'=> $request->start_date12, 'due_date'=> $request->due_date12, 'end_date'=> $request->end_date12, 'installment_amount'=> $request->amount]
                ];

                $fd = FeeDates::insert($data);

            }
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

    public function editSubCategory($id)
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

        $categorys = Category::where('school_id', $school_id)->get();
        $subcategory = SubCategory::where('fee_subcategory_id', $id)->first();

        return view('fees.edit_fees_subcategory',compact('subcategory', 'categorys', 'school_id', 'year_id'));
    }

    public function updateSubCategory(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');

        $category = Category::where('school_id', '=', $request->school_id)
                ->where('year_id', '=', $request->year_id)
                ->where('fee_category_name', '=', $request->fee_category)
                ->where('receipt_prefix', '=', $request->receipt_no)
                ->where('IsDelete', '=', '0')
                ->first();

        if($category == false)
        {
            $cg = Category::where('fee_category_id', $request->fee_category_id)
                    ->update([
                        'fee_category_name' => $request->fee_category,
                        'receipt_prefix' => $request->receipt_no,
                        'description' => $request->description,
                        'UpdatedBy' => $sid,
                        'UpdateDTTM' => $date
                    ]);

            if ($cg == true)
            {
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
        }else{
            $data = array();
            $data['success'] = '2';
            $data['error'] = 'true';
            $data['message'] = 'Category is already exist';
            return json_encode($data);
        }
    }

    public function deleteSubCategory(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');

        $dsc =  SubCategory::where('fee_subcategory_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dsc == true)
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
    ////////////////////////// ENd SubCategory //////////////////////////

}
?>
