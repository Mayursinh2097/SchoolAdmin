<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', [AdminController::class, 'index']);
Route::post('doLogin', [AdminController::class, 'doLogin']);
Route::get('doLogout', [AdminController::class, 'doLogout']);
Route::get('dashboard', [DashboardController::class, 'index']);

////////////////////////// School Details //////////////////////////

//School
Route::resource('/school', SchoolController::class);
Route::post('change_school_status',[SchoolController::class, 'change_school_status']);
Route::post('school/store',[SchoolController::class, 'store']);
Route::post('school/update',[SchoolController::class, 'update']);
Route::post('deleteschool',[SchoolController::class, 'destroy']);

//Class
Route::get('class',[SchoolController::class, 'viewClass']);
Route::post('class/addClass',[SchoolController::class, 'addClass']);
Route::get('class/{id}/edit',[SchoolController::class, 'editClass']);
Route::post('class/updateclass',[SchoolController::class, 'updateClass']);
Route::post('deleteclass',[SchoolController::class, 'deleteClass']);

//Division
Route::get('division',[SchoolController::class, 'viewDivision']);
Route::post('division/adddivision',[SchoolController::class, 'addDivision']);
Route::get('division/{id}/edit',[SchoolController::class, 'editDivision']);
Route::post('division/updatedivision',[SchoolController::class, 'updateDivision']);
Route::post('deletedivision',[SchoolController::class, 'deleteDivision']);

//State
Route::get('state',[SchoolController::class, 'viewState']);
Route::post('state/addstate',[SchoolController::class, 'addState']);
Route::get('state/{id}/edit',[SchoolController::class, 'editState']);
Route::post('state/updatestate',[SchoolController::class, 'updateState']);
Route::post('deletestate',[SchoolController::class, 'deleteState']);

//District
Route::get('district',[SchoolController::class, 'viewDistrict']);
Route::post('district/adddistrict',[SchoolController::class, 'addDistrict']);
Route::get('district/{id}/edit',[SchoolController::class, 'editDistrict']);
Route::post('district/updatedistrict',[SchoolController::class, 'updateDistrict']);
Route::post('deletedistrict',[SchoolController::class, 'deleteDistrict']);

//Religion
Route::get('religion',[SchoolController::class, 'viewReligion']);
Route::post('religion/addreligion',[SchoolController::class, 'addReligion']);
Route::get('religion/{id}/edit',[SchoolController::class, 'editReligion']);
Route::post('religion/updatereligion',[SchoolController::class, 'updateReligion']);
Route::post('deletereligion',[SchoolController::class, 'deleteReligion']);

//Subject
Route::get('subject',[SchoolController::class, 'viewSubject']);
Route::post('subject/addsubject',[SchoolController::class, 'addSubject']);
Route::get('subject/{id}/edit',[SchoolController::class, 'editSubject']);
Route::post('subject/updatesubject',[SchoolController::class, 'updateSubject']);
Route::post('deletesubject',[SchoolController::class, 'deleteSubject']);

//subject Class Allocation
Route::get('allocateClassSubject',[SchoolController::class, 'viewClassSubject']);
Route::post('allocateClassSubject/addClassSubject',[SchoolController::class, 'addClassSubject']);
Route::get('allocateClassSubject/{id}/edit',[SchoolController::class, 'editClassSubject']);
Route::post('allocateClassSubject/updateClassSubject',[SchoolController::class, 'updateClassSubject']);
Route::post('deleteClassSubject',[SchoolController::class, 'deleteClassSubject']);

//Lecture
Route::get('lecture',[SchoolController::class, 'viewLecture']);
Route::post('lecture/addLecture',[SchoolController::class, 'addLecture']);
Route::get('lecture/{id}/edit',[SchoolController::class, 'editLecture']);
Route::post('lecture/updateLecture',[SchoolController::class, 'updateLecture']);
Route::post('deleteLecture',[SchoolController::class, 'deleteLecture']);

//School Holiday
Route::get('holidays',[SchoolController::class, 'viewSchoolHoliday']);
Route::post('holidays/addHoliday',[SchoolController::class, 'addSchoolHoliday']);
Route::get('holidays/{id}/edit',[SchoolController::class, 'editSchoolHoliday']);
Route::post('holidays/updateHoliday',[SchoolController::class, 'updateSchoolHoliday']);
Route::post('deleteHoliday',[SchoolController::class, 'deleteSchoolHoliday']);

////////////////////////// END School Details //////////////////////////

////////////////////////// Student Details //////////////////////////

//Student Management
Route::resource('/students', StudentController::class);
Route::post('students/store',[StudentController::class, 'store']);
Route::post('imageUpload',[StudentController::class, 'imageUpload'])->name('uploadImage');
Route::post('students/update',[StudentController::class, 'update']);
Route::post('deleteStudent',[StudentController::class, 'destroy']);
Route::get('student/selectDiv',[StudentController::class, 'selectDiv']);
Route::get('student/selectStudentDetails',[StudentController::class, 'selectStudentDetails']);

//Student Roll Number
Route::get('student/rollNumber',[StudentController::class, 'rollNumber']);
Route::get('student/getStudents',[StudentController::class, 'getStudents']);
Route::post('student/saveStudentRollNumber',[StudentController::class, 'saveStudentRollNumber']);

//School LC
Route::get('student/LC',[StudentController::class, 'viewStudents']);
Route::get('student/getStudentsList',[StudentController::class, 'getStudentsList']);
Route::get('student/addStudentLC/Id={id}&CL={cid}&StuName={name}',[StudentController::class, 'addStudentLC']);
Route::post('student/addStudLC',[StudentController::class, 'addStudLC']);

////////////////////////// END Student Details //////////////////////////

////////////////////////// Teacher Details //////////////////////////

//Teacher Management
Route::resource('/teachers', TeacherController::class);
Route::post('viewTeacher',[TeacherController::class, 'viewTeacher']);
Route::post('teachers/store',[TeacherController::class, 'store']);
Route::post('teachers/imageUpload',[TeacherController::class, 'imageUpload'])->name('teacherUploadImage');
Route::post('teachers/update',[TeacherController::class, 'update']);
Route::post('changeStatus',[TeacherController::class, 'changeStatus']);
Route::post('deleteUser',[TeacherController::class, 'destroy']);

////////////////////////// END Teacher Details //////////////////////////

////////////////////////// Fees Details //////////////////////////

//Category
Route::get('category',[FeesController::class, 'viewCategory']);
Route::post('category/addCategory',[FeesController::class, 'addCategory']);
Route::get('category/{id}/edit',[FeesController::class, 'editCategory']);
Route::post('category/updateCategory',[FeesController::class, 'updateCategory']);
Route::post('deleteCategory',[FeesController::class, 'deleteCategory']);

//SubCategory
Route::get('subcategory',[FeesController::class, 'viewSubCategory']);
Route::get('subcategory/create',[FeesController::class, 'createSubCategory']);
Route::post('subcategory/addSubCategory',[FeesController::class, 'addSubCategory']);
Route::get('subcategory/{id}/edit',[FeesController::class, 'editSubCategory']);
Route::post('subcategory/updateSubCategory',[FeesController::class, 'updateSubCategory']);
Route::post('deleteSubCategory',[FeesController::class, 'deleteSubCategory']);

//Fees Allocation
Route::get('feeAllocation',[FeesController::class, 'viewFeeAllocation']);
Route::get('selectStudent',[FeesController::class, 'selectStudent']);
Route::get('feeAllocation/selectSubCat',[FeesController::class, 'selectSubCat']);
Route::post('feeAllocation/addFeeAllocation',[FeesController::class, 'addFeeAllocation']);
Route::get('feeAllocation/{id}/edit',[FeesController::class, 'editFeeAllocation']);
Route::post('feeAllocation/updateFeeAllocation',[FeesController::class, 'updateFeeAllocation']);
Route::post('deletefeeAllocation',[FeesController::class, 'deleteFeeAllocation']);

//Fees Template
Route::get('feeTemplate',[FeesController::class, 'viewTemplate']);
Route::post('feeTemplate/updateFeeTemplate',[FeesController::class, 'updateFeeTemplate']);
Route::post('imageUpload',[FeesController::class, 'templateImageUpload'])->name('templateuploadImage');


//Fees Collection
Route::get('feeCollection',[FeesController::class, 'viewFeeCollection']);
Route::get('getStudentDetail',[FeesController::class, 'getStudentDetail']);
Route::post('select_pre_year_student_fees',[FeesController::class, 'select_pre_year_student_fees']);
Route::post('feeCollection/addFeeCollection',[FeesController::class, 'addFeeCollection']);
Route::get('feeCollection/{id}/edit',[FeesController::class, 'editFeeCollection']);
Route::post('feeCollection/updateFeeCollection',[FeesController::class, 'updateFeeCollection']);
Route::post('deleteFeeCollection',[FeesController::class, 'deleteFeeCollection']);

////////////////////////// END Fees Details //////////////////////////
