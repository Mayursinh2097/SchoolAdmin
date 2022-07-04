<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;

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

//Student
Route::resource('/students', StudentController::class);
Route::post('change_school_status',[StudentController::class, 'change_school_status']);
Route::post('students/store',[StudentController::class, 'store']);
Route::post('students/update',[StudentController::class, 'update']);
Route::post('deleteschool',[StudentController::class, 'destroy']);
Route::get('student/selectDiv',[StudentController::class, 'selectDiv']);
Route::get('student/selectStudentDetails',[StudentController::class, 'selectStudentDetails']);

////////////////////////// Student Details //////////////////////////
