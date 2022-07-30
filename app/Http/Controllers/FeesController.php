<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentRollNumber;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\FeeDates;
use App\Models\FeeAllocation;
use App\Models\FeeCollection;
use App\Models\FeeTemplate;

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

        $subcategory = SubCategory::where('school_id', '=', $request->school_id)
                ->where('YearId', '=', $request->year_id)
                ->where('fee_category_id', '=', $request->fee_category_id)
                ->where('fee_subcategory_name', '=', $request->fee_subcategory_name)
                ->where('amount', '=', $request->amount)
                ->where('IsDelete', '=', '0')
                ->first();

        if($subcategory == false)
        {
            $cg = SubCategory::where('fee_category_id', $request->fee_category_id)
                    ->update([
                        'fee_subcategory_name' => $request->fee_subcategory_name,
                        'fee_category_id' => $request->fee_category_id,
                        'amount' => $request->amount,
                        'fee_type' => $request->fee_type,
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
            $data['message'] = 'SubCategory is already exist';
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

    ////////////////////////// FeeAllocation //////////////////////////

    public function viewFeeAllocation()
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

        $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();

        $feeallocations = FeeAllocation::select('fee_allocation.*', 'fee_category_name', 'fee_subcategory_name', 'ClassName', 'DivisionName', 'StudentName')
            ->join('fees_category', 'fees_category.fee_category_id', '=', 'fee_allocation.fee_category_id')
            ->join('fees_subcategory', 'fees_subcategory.fee_subcategory_id', '=', 'fee_allocation.fee_subcategory_id')
            // ->join('student_roll_number', 'student_roll_number.Student_id', '=', 'fee_allocation.StudentId')
            ->join('student_master', 'student_master.StudentId', '=', 'fee_allocation.StudentId')
            ->join('class_master', 'class_master.ClassId', '=', 'fee_allocation.ClassId')
            ->join('division_master', 'division_master.DivisionId', '=', 'fee_allocation.DivisionId')
            ->where('fee_allocation.school_id', '=', $school_id)
            ->where('fee_allocation.YearId', '=', $year_id)
            ->where('fee_allocation.IsDelete', '=', '0')
            ->orderby('fee_allocation.fee_allocation_id', 'desc')
            ->get();

        return view('fees.fees_allocation', compact('feeallocations', 'categorys', 'classes', 'sid', 'RoleId', 'school_id', 'year_id'));
    }

    public function selectSubCat(Request $request)
    {
        $feeSubCat = SubCategory::select('fee_subcategory_id', 'fee_subcategory_name')
                ->where('fee_category_id', $request->fee_category_id)
                ->where('IsDelete', '=', '0')
                ->get();

        if ($feeSubCat == true)
        {
            $data = array();
            $data['success'] = 1;
            $data['data'] = $feeSubCat;
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

    public function selectStudent(Request $request)
    {
        $students = StudentRollNumber::select('student_master.StudentId', 'StudentName')
                ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
                ->where('Current_Class', $request->class_id)
                ->where('Current_Div', $request->div_id)
                ->where('Year_Id', $request->year_id)
                ->where('student_roll_number.IsDelete', '=', '0')
                ->whereNull('student_master.lc_id')
                ->orderby('RollNumber', 'asc')
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

    public function addFeeAllocation(Request $request)
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

        if ($request->student_id == "all") 
        {
            $students = Student::select('student_master.*')
                ->join('student_roll_number', 'student_roll_number.Student_id', '=', 'student_master.StudentId')
                ->where('Year_Id', '=', $request->year_id)
                ->where('Current_Class', '=', $request->class_id)
                ->where('Current_Div', '=', $request->div_id)
                ->where('student_roll_number.IsDelete', '=', '0')
                ->whereNull('student_roll_number.lc_id')
                ->whereNull('student_master.lc_id')
                ->orderby('RollNumber', 'asc')
                ->get();

            foreach($students as $key => $value)
            {
                $stud_id = $value->StudentId;
                $fee_allocation = FeeAllocation::where('school_id', '=', $request->school_id)
                    ->where('YearId', '=', $request->year_id)
                    ->where('fee_category_id', '=', $request->fee_category_id)
                    ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                    ->where('StudentId', '=', $stud_id)
                    ->where('IsDelete', '=', '0')
                    ->first();

                if ($fee_allocation == false) 
                {
                    $fa = new FeeAllocation();
                    $fa->school_id = $request->school_id;
                    $fa->YearId = $request->year_id;
                    $fa->fee_category_id = $request->fee_category_id;
                    $fa->fee_subcategory_id = $request->fee_subcategory_id;
                    $fa->ClassId = $request->class_id;
                    $fa->DivisionId = $request->div_id;
                    $fa->StudentId = $stud_id;
                    $fa->CreatedBy = $sid;
                    $fa->save();

                    $fee_allocation_id = $fa->id;

                    if ($fa == true)
                    {
                        $fee_subcat = SubCategory::where('school_id', '=', $request->school_id)
                                ->where('YearId', '=', $request->year_id)
                                ->where('fee_category_id', '=', $request->fee_category_id)
                                ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                                ->where('IsDelete', '=', '0')
                                ->orderby('fee_subcategory_id', 'asc')
                                ->first();

                        $subCatId = $fee_subcat->fee_subcategory_id;
                        $fee_type = $fee_subcat->fee_type;
                        $actual_amount = $fee_subcat->amount;
                        $fine = 0;
                        $discount = 0;
                        $scholarship = 0;

                        if($fee_type == 1) 
                        {
                            $due_amount = 1 * $actual_amount;
                        }
                        else if($fee_type == 2) 
                        {
                            $due_amount = 2 * $actual_amount;
                        }
                        else if($fee_type == 3) 
                        {
                            $due_amount = 3 * $actual_amount;
                        }
                        else if($fee_type == 4) 
                        {
                            $due_amount = 4 * $actual_amount;
                        }
                        else if($fee_type == 12) 
                        {
                            $due_amount = 12 * $actual_amount;
                        }

                        $fc = new FeeCollection();
                        $fc->school_id = $request->school_id;
                        $fc->Year_Id = $request->year_id;
                        $fc->class_id = $request->class_id;
                        $fc->student_id = $stud_id;
                        $fc->fee_subcategory_id = $request->fee_subcategory_id;
                        $fc->fee_type = $fee_type;
                        $fc->actual_amount = $actual_amount;
                        $fc->due_amount = $due_amount;
                        $fc->fine = $fine;
                        $fc->discount = $discount;
                        $fc->scholarship = $scholarship;
                        $fc->CreatedBy = $sid;
                        $fc->save();

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
                    $data['success'] = '1';
                    $data['error'] = 'false';
                    $data['message'] = 'Some Records is already exist';
                    return json_encode($data);   
                }
            }
        }else{

            $fee_allocation = FeeAllocation::where('school_id', '=', $request->school_id)
                ->where('YearId', '=', $request->year_id)
                ->where('fee_category_id', '=', $request->fee_category_id)
                ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                ->where('StudentId', '=', $request->student_id)
                ->where('IsDelete', '=', '0')
                ->first();

            if ($fee_allocation == false) 
            {
                $fa = new FeeAllocation();
                $fa->school_id = $request->school_id;
                $fa->YearId = $request->year_id;
                $fa->fee_category_id = $request->fee_category_id;
                $fa->fee_subcategory_id = $request->fee_subcategory_id;
                $fa->ClassId = $request->class_id;
                $fa->DivisionId = $request->div_id;
                $fa->StudentId = $request->student_id;
                $fa->CreatedBy = $sid;
                $fa->save();

                $fee_allocation_id = $fa->id;

                if ($fa == true)
                {
                    $fee_subcat = SubCategory::where('school_id', '=', $request->school_id)
                            ->where('YearId', '=', $request->year_id)
                            ->where('fee_category_id', '=', $request->fee_category_id)
                            ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                            ->where('IsDelete', '=', '0')
                            ->orderby('fee_subcategory_id', 'asc')
                            ->first();

                    $subCatId = $fee_subcat->fee_subcategory_id;
                    $fee_type = $fee_subcat->fee_type;
                    $actual_amount = $fee_subcat->amount;
                    $fine = 0;
                    $discount = 0;
                    $scholarship = 0;

                    if($fee_type == 1) 
                    {
                        $due_amount = 1 * $actual_amount;
                    }
                    else if($fee_type == 2) 
                    {
                        $due_amount = 2 * $actual_amount;
                    }
                    else if($fee_type == 3) 
                    {
                        $due_amount = 3 * $actual_amount;
                    }
                    else if($fee_type == 4) 
                    {
                        $due_amount = 4 * $actual_amount;
                    }
                    else if($fee_type == 12) 
                    {
                        $due_amount = 12 * $actual_amount;
                    }

                    $fc = new FeeCollection();
                    $fc->school_id = $request->school_id;
                    $fc->Year_Id = $request->year_id;
                    $fc->class_id = $request->class_id;
                    $fc->student_id = $request->student_id;
                    $fc->fee_subcategory_id = $subCatId;
                    $fc->fee_type = $fee_type;
                    $fc->actual_amount = $actual_amount;
                    $fc->due_amount = $due_amount;
                    $fc->fine = $fine;
                    $fc->discount = $discount;
                    $fc->scholarship = $scholarship;
                    $fc->CreatedBy = $sid;
                    $fc->save();

                    $data = array();
                    $data['success'] = '1';
                    $data['error'] = 'false';
                    $data['message'] = 'Inserted Successfully';
                    return json_encode($data);
                }
            }else
            {
                $data = array();
                $data['success'] = '0';
                $data['error'] = 'true';
                $data['message'] = 'Somthing Wrong!!';
                return json_encode($data);
            }
        }
    }

    public function editFeeAllocation($id)
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

        $categorys = Category::where('school_id', '=', $school_id)
                ->where('year_id', '=', $year_id)
                ->where('IsDelete', '=', '0')
                ->orderby('fee_category_id', 'asc')
                ->get();

        $feeallocation = FeeAllocation::select('fee_allocation.*', 'ClassName', 'DivisionName', 'StudentName')
                ->join('student_master', 'student_master.StudentId', '=', 'fee_allocation.StudentId')
                ->join('class_master', 'class_master.ClassId', '=', 'fee_allocation.ClassId')
                ->join('division_master', 'division_master.DivisionId', '=', 'fee_allocation.DivisionId')
                ->where('fee_allocation_id', $id)
                ->where('fee_allocation.IsDelete', '=', '0')
                ->first();

        return view('fees.edit_fees_allocation',compact('feeallocation', 'categorys', 'school_id', 'year_id'));
    }

    public function updateFeeAllocation(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');
        // dd($request->all());
        $fee_allocation = FeeAllocation::where('school_id', '=', $request->school_id)
                ->where('YearId', '=', $request->year_id)
                ->where('fee_category_id', '=', $request->fee_category_id)
                ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                ->where('StudentId', '=', $request->student_id)
                ->where('IsDelete', '=', '0')
                ->first();

        if($fee_allocation == false)
        {
            $fa = FeeAllocation::where('fee_allocation_id', $request->fee_allocation_id)
                    ->update([
                        'fee_category_id' => $request->fee_category_id,
                        'fee_subcategory_id' => $request->fee_subcategory_id,
                        'UpdatedBy' => $sid,
                        'UpdateDTTM' => $date
                    ]);

            if ($fa == true)
            {
                $fee_subcat = SubCategory::where('school_id', '=', $request->school_id)
                        ->where('YearId', '=', $request->year_id)
                        ->where('fee_category_id', '=', $request->fee_category_id)
                        ->where('fee_subcategory_id', '=', $request->fee_subcategory_id)
                        ->where('IsDelete', '=', '0')
                        ->orderby('fee_subcategory_id', 'asc')
                        ->first();

                $subCatId = $fee_subcat->fee_subcategory_id;
                $fee_type = $fee_subcat->fee_type;
                $actual_amount = $fee_subcat->amount;
                $fine = 0;
                $discount = 0;
                $scholarship = 0;

                if($fee_type == 1) 
                {
                    $due_amount = 1 * $actual_amount;
                }
                else if($fee_type == 2) 
                {
                    $due_amount = 2 * $actual_amount;
                }
                else if($fee_type == 3) 
                {
                    $due_amount = 3 * $actual_amount;
                }
                else if($fee_type == 4) 
                {
                    $due_amount = 4 * $actual_amount;
                }
                else if($fee_type == 12) 
                {
                    $due_amount = 12 * $actual_amount;
                }
            // \DB::enableQueryLog();
                $fc = FeeCollection::where('student_id', $request->student_id)
                    ->where('class_id', $request->class_id)
                    ->where('school_id', $request->school_id)
                    ->where('Year_Id', $request->year_id)
                    ->update([
                        'fee_subcategory_id' => $subCatId,
                        'fee_type' => $fee_type,
                        'actual_amount' => $actual_amount,
                        'due_amount' => $due_amount,
                        'fine' => $fine,
                        'discount' => $discount,
                        'scholarship' => $scholarship,
                        'UpdatedBy' => $sid,
                        'UpdateDTTM' => $date
                    ]);
                // dd(\DB::getQueryLog());exit;

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
            $data['message'] = 'SubCategory is already exist';
            return json_encode($data);
        }
    }

    public function deleteFeeAllocation(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');

        $dsc =  FeeAllocation::where('fee_allocation_id', $request->id)->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

        if ($dsc == true)
        {
            $fc = FeeCollection::where('student_id', $request->StudentId)
                    ->where('class_id', $request->ClassId)
                    ->where('fee_subcategory_id', $request->fee_subcategory_id)
                    ->where('school_id', $request->school_id)
                    ->where('Year_Id', $request->year_id)
                    ->update(['IsDelete' => '1', 'UpdatedBy' => $sid, 'UpdateDTTM' => $date]);

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
    ////////////////////////// ENd FeeAllocation //////////////////////////

    ////////////////////////// Fees Template //////////////////////////

    public function viewTemplate()
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

        $feetemplate = FeeTemplate::where('school_id', '=', $school_id)
            ->where('year_id', '=', $year_id)
            ->where('IsDelete', '=', '0')
            ->first();

        return view('fees.fees_template', compact('feetemplate', 'sid', 'RoleId', 'school_id', 'year_id'));
    }

    public function templateImageUpload(Request $request)
    {
        // echo "Hii";exit;
        $croped_image = $request->image;

        list($type, $croped_image) = explode(';', $croped_image);
        list(, $croped_image)      = explode(',', $croped_image);

        $croped_image = base64_decode($croped_image);
        $image_name= time().'.png';
        $path = public_path() . "../file_upload/template/".$image_name;
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

    public function updateFeeTemplate(Request $request)
    {
        $data = Session::all();
        $sid =  $data['sid'];
        $date = date('Y-m-d H:i:s');

        $feetemp = FeeTemplate::where('school_id', '=', $request->school_id)
                ->where('year_id', '=', $request->year_id)
                ->where('IsDelete', '=', '0')
                ->first();

        if($feetemp == true)
        {
            $temp_id = $feetemp->template_id;
            $ft = FeeTemplate::where('template_id', $temp_id)
                    ->update([
                        'institution_name' => $request->institution_name,
                        'institution_address' => $request->institution_address,
                        'phone_number' => $request->phone_number,
                        'photo' => $request->photo,
                        'UpdatedBy' => $sid,
                        'UpdateDTTM' => $date
                    ]);

            if ($ft == true)
            {
                $data = array();
                $data['success'] = '2';
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

            $ft = new FeeTemplate();
            $ft->school_id = $request->school_id;
            $ft->year_id = $request->year_id;
            $ft->institution_name = $request->institution_name;
            $ft->institution_address = $request->institution_address;
            $ft->phone_number = $request->phone_number;
            $ft->photo = $request->photo;
            $ft->CreatedBy = $sid;
            $ft->save();

            if($ft == true)
            {
                $data = array();
                $data['success'] = '1';
                $data['error'] = 'false';
                $data['message'] = 'Template Inserted Successfully';
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

    ////////////////////////// ENd Fees Template //////////////////////////

    ////////////////////////// Fee Colletion //////////////////////////

    public function viewFeeCollection()
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

         $classes = SchoolClass::where('school_id', '=', $school_id)
            ->where('IsDelete', '=', '0')
            ->orderby('ClassId', 'asc')
            ->get();
        return view('fees.fees_collection', compact('classes', 'sid', 'RoleId', 'school_id', 'year_id'));
    }

    public function getStudentDetail(Request $request)
    {
        $sd = StudentRollNumber::select('student_master.StudentId', 'StudentName', 'FatherName', 'ContactNumber1', 'CurrentAddress', 'ClassName', 'DivisionName', 'student_roll_number.Roll_Number')
                ->join('student_master', 'student_master.StudentId', '=', 'student_roll_number.Student_id')
                ->join('class_master', 'class_master.ClassId', '=', 'student_roll_number.Current_Class')
                ->join('division_master', 'division_master.DivisionId', '=', 'student_roll_number.Current_Div')
                ->where('student_roll_number.Student_id', $request->student_id)
                ->where('Year_Id', $request->year_id)
                ->where('student_roll_number.IsDelete', '=', '0')
                ->first();

        if ($sd == true)
        {
            $data = array();
            $data['success'] = 1;
            $data['data'] = $sd;
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

    public function addFeeCollection(Request $request)
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

    public function editFeeCollection($id)
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

    public function updateFeeCollection(Request $request)
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

    public function deleteFeeCollection(Request $request)
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
    ////////////////////////// ENd Fee Colletion //////////////////////////
}
?>
