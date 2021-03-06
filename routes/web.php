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


Route::get('/', 'MainController@dashboard')->name('/');
Route::get('guest', 'MainController@guest')->name('guest');

//admin only
Route::group(['middleware' => ['auth', 'role:admin']], function()
{
    Route::resource('/program', 'ProgramController');
    Route::resource('/school', 'SchoolController');
    Route::resource('/classroom', 'ClassroomController');
    Route::resource('/section', 'SectionController');
    Route::resource('/course', 'CourseController');
    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');
    Route::get('/adminhome', 'AdminController@view_dashboard')->name('adminhome');
});

//all users
Route::group(['middleware' => ['auth', 'role:admin|teacher|student|guest']], function()
{
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
    Route::get('/teacherhome', 'TeacherController@view_dashboard')->name('teacherhome');
    Route::get('/teachersubmissions', 'SubmissionController@unmarked_submissions')->name('teachersubmissions');
});

//student only
Route::group(['middleware' => ['auth', 'role:admin|student']], function()
{
    Route::resource('/student', 'StudentController');
    Route::get('/studenthome', 'StudentController@view_dashboard')->name('studenthome');
    Route::get('portal', 'StudentController@view_portal')->name('portal');
});