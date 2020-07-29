<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Session;
use App\Models\Attendance;
use DB;
use Carbon\Carbon;
use App\User;
use Auth;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin'))
        {
            $teacher = Teacher::with('sessions', 'user')->paginate(10);
            return view('admin.teacher.teacher_list', compact('teacher'));
        }
        else
        {
            $teacher = (Teacher::where('user_id', auth()->user()->id)->paginate(10))[0];
            return view('admin.teacher.teacher_list', compact('teacher'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->hasRole('admin'))
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
        else
        {
            return redirect()->route('teacher.index');
        }
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
            'user_id' => 'required'
        ]);
        $path = $request->file('image')->storeAs('img', auth()->user()->name.' - '.$_FILES['image']['name']);
        DB::table('teachers')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
            'image' => $path,
        ]);
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
        if(auth()->user()->hasRole('admin'))
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
        else
        {
            $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];
    
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->hasRole('admin|teacher'))
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
        else
        {
            $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];
    
            $user = User::all();
            $user_name = [];
            foreach($user as $user)
            {
                $user_name[$user->id] = $user->name;
            }
    
            return view('admin.teacher.teacher_update', compact('teacher', 'user_name'));
        }
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
        if(auth()->user()->hasRole('admin'))
        {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'contact' => 'required|string|max:100',
                'address' => 'required|string|max:300',
            ]);
            $teacher = Teacher::find($id)->update($request->all());
            return redirect()->route('teacher.show', $id)->with('message', 'Teacher updated successfully!');
        }
        else
        {
            $teacher = $teacher = Teacher::find($id);
            if($teacher->user_id == auth()->user()->id)
            {
                $this->validate($request, [
                    'image' => 'required'
                ]);
                $teacher = Teacher::find($id)->update($request->all());
                return redirect()->route('teacher.show', $id)->with('message', 'Teacher updated successfully!');
            }
            return redirect()->route('teacher.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(auth()->user()->hasRole('admin'))
        {
            Teacher::where('id', $id)->delete();
            return redirect()->route('teacher.index')->with('success','Teacher Deleted Successfully');
        }
        else
        {
            return redirect()->route('teacher.index');
        }
    }

    public function view_dashboard(Request $request)
    {
        $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];

        //live class count
        $live_class_count = 0;
        foreach($teacher->sessions as $session)
        {
            if($session->state == "enable")
            {
                $live_class_count += 1;
            }
        }
        $attendances = Attendance::where('user_id', $teacher->user_id)
                        ->whereDate('check_in', '<', Carbon::now()->addMonths(1))
                        ->whereDate('check_in', '>', Carbon::now()->subMonths(1))
                        ->get();

        //unmarked submissions
        $unmarked_submissions_count = 0;
        foreach($teacher->sessions as $session)
        {
            foreach($session->assignments as $assignment)
            {
                foreach($assignment->submissions as $submissions)
                {
                    if($submissions->marks == NULL)
                    {
                        $unmarked_submissions_count += 1;
                    }
                    else
                    {
                        continue;
                    }
                }
            }
        }

        //work hours
        $previous_work_hours = 0;
        $counter = -1;
        if(count($attendances) > 0){
            foreach($attendances as $attendance)
            {
                if($attendance->check_in && $attendance->check_out)
                {
                    $check_in = Carbon::parse($attendance->check_in);
                    $check_out = Carbon::parse($attendance->check_out);
                    $previous_work_hours += $check_in->diffInSeconds($check_out);
                }
                $counter++;
            }

            if($attendances[$counter]->check_out)
            {
                $wh = gmdate('H:i:s', $previous_work_hours);
                $check = 'out';
                $days = gmdate('d H:i:s', $previous_work_hours);
                $total_days = substr($days,0,2)-1;
            }
            else
            {
                $current_checkin = Carbon::parse($attendances[$counter]->check_in);
                $currenttime = Carbon::now()->addHours(5);
                $work_hours = $current_checkin->diffInSeconds($currenttime);
                $total_work_hours = $work_hours + $previous_work_hours;
                $wh = gmdate('H:i:s', $total_work_hours);
                $check = 'in';
                $days = gmdate('d H:i:s', $total_work_hours);
                $total_days = substr($days,0,2)-1;
            }
        }
        else
        {
            $wh = gmdate('H:i:s',0);
            $check = 'out';
            $total_days = 0;
        }

        return view('admin.dashboard.teacher_dashboard', compact('teacher', 'live_class_count','unmarked_submissions_count', 'wh','check','total_days'));
    }
}
