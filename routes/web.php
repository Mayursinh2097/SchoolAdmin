<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;

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
