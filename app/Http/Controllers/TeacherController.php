<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Session;
use App\Models\Attendance;
use Carbon\Carbon;
use App\User;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacher = Teacher::with('sessions', 'user')->get();
        return view('admin.teacher.teacher_list', compact('teacher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teacher = Teacher::with('sessions', 'user')->get();

        $user = User::all();
        $user_name = [];
        foreach($user as $user)
        {
            $user_name[$user->id] = $user->name;
        }
        
        return view('admin.teacher.teacher_create', compact('teacher', 'user_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'address' => 'required|string|max:300',
        ]);
        $teacher = Teacher::create($request->all());
        return redirect()->route('teacher.index')->with('success','Teacher Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = Teacher::find($id);

        $raw_sessions = Session::where('teacher_id', $teacher->id)->get();
        $sessions = [];
        foreach($raw_sessions as $raw_session)
        {
            $class_title = $raw_session->section->classroom->title;

            $section_title = $raw_session->section->title;

            $section_detail = $class_title." - ".$section_title;

            $course_title = $raw_session->course->title;

            $session_detail = $section_detail." - ".$course_title;

            $sessions[$raw_session->id] = $session_detail;

        }

        return view('admin.teacher.teacher_detail', compact('teacher', 'sessions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);

        $user = User::all();
        $user_name = [];
        foreach($user as $user)
        {
            $user_name[$user->id] = $user->name;
        }

        return view('admin.teacher.teacher_update', compact('teacher', 'user_name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'contact' => 'required|string|max:100',
            'address' => 'required|string|max:300',
        ]);
        $teacher = Teacher::find($id)->update($request->all());
        return redirect()->route('teacher.show', $id)->with('message', 'Teacher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Teacher::where('id', $id)->delete();
        return redirect()->route('teacher.index')->with('success','Teacher Deleted Successfully');
    }

    public function view_dashboard(Request $request)
    {
        $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];
        $live_class_count = 0;
        foreach($teacher->sessions as $session)
        {
            if($session->state == "enable")
            {
                $live_class_count += 1;
            }
        }
        $attendances = Attendance::where('user_id', $teacher->user_id)
                        ->whereDate('check_out', '<', Carbon::now()->addMonths(1))
                        ->whereDate('check_in', '>', Carbon::now()->subMonths(1))
                        ->get();
        $work_hours = 1;
        foreach($attendances as $attendance)
        {
            $check_in = Carbon::parse($attendance->check_in);
            $check_out = Carbon::parse($attendance->check_out);
            $work_hours += $check_in->diffInSeconds($check_out);
        }
        $work_hours = gmdate('H:i:s',$work_hours);
        return view('admin.dashboard.teacher_dashboard', compact('teacher', 'live_class_count', 'work_hours'));
    }
}
