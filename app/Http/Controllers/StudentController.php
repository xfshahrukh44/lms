<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use App\Models\Submission;
use App\Models\Attendance;
use App\User;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::with('section', 'user')->get();
        return view('admin.student.student_list', compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $student = Student::with('section', 'user')->get();

        $user = User::all();
        $user_name = [];
        foreach($user as $user)
        {
            $user_name[$user->id] = $user->name;
        }

        $section = Section::all();
        $section_name = [];
        foreach($section as $section)
        {
            $section_name[$section->id] = $section->classroom->title." - ".$section->title;
        }
        
        return view('admin.student.student_create', compact('student', 'user_name', 'section_name'));
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
            'section_id' => 'required'
        ]);
        $student = Student::create($request->all());
        return redirect()->route('student.index')->with('success','Student Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        $class_title = $student->section->classroom->title;
        $section_title = $student->section->title;
        $of = $class_title." - ".$section_title;

        return view('admin.student.student_detail', compact('student', 'of'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);

        $user = User::all();
        $user_name = [];
        foreach($user as $user)
        {
            $user_name[$user->id] = $user->name;
        }

        $section = Section::all();
        $section_name = [];
        foreach($section as $section)
        {
            $section_name[$section->id] = $section->classroom->title." - ".$section->title;
        }

        return view('admin.student.student_update', compact('student', 'user_name', 'section_name'));
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
            'section_id' => 'required'
        ]);
        $student = Student::find($id)->update($request->all());
        return redirect()->route('student.show', $id)->with('message', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::where('id', $id)->delete();
        return redirect()->route('student.index')->with('success','Student Deleted Successfully');
    }
    
    public function view_dashboard(Request $request)
    {
        $student = (Student::where('user_id', auth()->user()->id)->get())[0];
        $live_class_count = 0;
        foreach($student->section->sessions as $session)
        {
            if($session->state == "enable")
            {
                $live_class_count += 1;
            }
        }
        $attendances = Attendance::where('user_id', $student->user_id)
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
        return view('admin.dashboard.student_dashboard', compact('student', 'live_class_count', 'work_hours'));
    }

    public function view_portal()
    {
        $student = Student::where('user_id', auth()->user()->id)->get();
        $section = Section::find($student[0]->section_id);
        $dict = [];
        $main = [];
        foreach($section->sessions as $session)
        {
            $dict['course_title'] = $session->course->title;
            $dict['max_marks'] = 0;
            $dict['marks_obtained'] = 0;
            $dict['percentage'] = 0;
            foreach($session->assignments as $assignment)
            {
                $check = Submission::where('student_id', $student[0]->id && 'assignment_id', $assignment->id)->get();
                if(count($check) > 0 && $check[0]->marks != NULL)
                {
                    $dict['max_marks'] += $assignment->marks;
                    $dict['marks_obtained'] += $check[0]->marks;
                }
                else
                {
                    continue;
                }
            }
            if($dict['max_marks'] == 0)
            {
                $dict['percentage'] = 0;
            }
            else
            {
                $dict['percentage'] = ($dict['marks_obtained'] / $dict['max_marks']) * 100;
            }
            array_push($main, $dict);
            
        } 
        return view('admin.student.student_portal', compact('main', 'student'));
        // dd($main);
        // exit();
    }
}
