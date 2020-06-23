<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();



//admin only
Route::group(['middleware' => ['auth', 'role:admin']], function()
{
    Route::get('/', 'SchoolController@index');
    Route::resource('/program', 'ProgramController');
    Route::resource('/school', 'SchoolController');
    Route::resource('/classroom', 'ClassroomController');
    Route::resource('/section', 'SectionController');
    Route::resource('/course', 'CourseController');
    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');
});

//all users
Route::group(['middleware' => ['auth', 'role:admin|teacher|student']], function()
{
    Route::get('/', 'SessionController@index');
    Route::resource('/session', 'SessionController');
    Route::resource('/attendance', 'AttendanceController');
    Route::resource('/assignment', 'AssignmentController');
    Route::get('/asgn', 'AssignmentController@download')->name('asgn');
    Route::resource('/submission', 'SubmissionController');
    Route::get('/submit', 'SubmissionController@download')->name('submit');
    Route::get('/statusURL', 'AttendanceController@find_check_in_out_status');
    Route::get('/checkInURL', 'AttendanceController@check_in');
    Route::get('/checkOutURL', 'AttendanceController@check_out');
});

//teacher only
Route::group(['middleware' => ['auth', 'role:admin|teacher']], function()
{
    Route::resource('/teacher', 'TeacherController');
    Route::get('/teacherhome', 'TeacherController@view_dashboard');
    Route::get('/teachersubmissions', 'SubmissionController@unmarked_submissions')->name('teachersubmissions');
});

//student only
Route::group(['middleware' => ['auth', 'role:admin|student']], function()
{
    Route::resource('/student', 'StudentController');
    Route::get('/studenthome', 'StudentController@view_dashboard');
    Route::get('portal', 'StudentController@view_portal')->name('portal');
});