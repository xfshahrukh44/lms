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
        if(auth()->user()->hasRole('admin'))
        {
            $student = Student::with('section', 'user')->get();
            return view('admin.student.student_list', compact('student'));
        }
        else
        {
            $student = (Student::where('user_id', auth()->user()->id)->get())[0];
            return $this->show($student->id);
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
        else
        {
            return redirect()->route('student.index');
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
        if(auth()->user()->hasRole('admin'))
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
        else
        {
            return redirect()->route('student.index');
        }
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
            $student = Student::find($id);
            $class_title = $student->section->classroom->title;
            $section_title = $student->section->title;
            $of = $class_title." - ".$section_title;
    
            return view('admin.student.student_detail', compact('student', 'of'));
        }
        else
        {
            if($id == auth()->user->id)
            {
                $student = Student::find($id);
                $class_title = $student->section->classroom->title;
                $section_title = $student->section->title;
                $of = $class_title." - ".$section_title;
        
                return view('admin.student.student_detail', compact('student', 'of'));
            }
            else
            {
                return redirect()->route('student.index');
            }
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
        if(auth()->user()->hasRole('admin'))
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
        else
        {
            return redirect()->route('student.index');
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
                'section_id' => 'required'
            ]);
            $student = Student::find($id)->update($request->all());
            return redirect()->route('student.show', $id)->with('message', 'Student updated successfully!');
        }
        else
        {
            return redirect()->route('student.index');
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
            Student::where('id', $id)->delete();
            return redirect()->route('student.index')->with('success','Student Deleted Successfully');
        }
        else
        {
            return redirect()->route('student.index');
        }
    }
    
    public function view_dashboard(Request $request)
    {
        $student = (Student::where('user_id', auth()->user()->id)->get())[0];

        //new assignments
        $assignment_count = 0;
        $section = Section::find($student->section_id);
        foreach($section->sessions as $session)
        {
            foreach($session->assignments as $asgn)
            {
                $check = Submission::where('student_id', $student->id && 'assignment_id', $asgn->id)->get();
                if(count($check) == 0)
                {
                    $assignment_count += 1;
                }
                else
                {
                    continue;
                }
            }
        }
        
        //your submissions
        $submission = Submission::where('student_id', $student->id)->get();
        $submission_count = count($submission);

        //live classes
        $live_class_count = 0;
        foreach($student->section->sessions as $session)
        {
            if($session->state == "enable")
            {
                $live_class_count += 1;
            }
        }

        //time spent this month
        $attendances = Attendance::where('user_id', $student->user_id)
                        ->whereDate('check_in', '<', Carbon::now()->addMonths(1))
                        ->whereDate('check_in', '>', Carbon::now()->subMonths(1))
                        ->get();
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

        //grade
        $grade = $this->view_portal(1);
        return view('admin.dashboard.student_dashboard', compact('assignment_count', 'submission_count', 'student', 'live_class_count', 'wh','check','total_days', 'grade'));
    }

    public function view_portal($dashboard = 0)
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
        if($dashboard != 1)
        {
            return view('admin.student.student_portal', compact('main', 'student'));
        }
        else
        {
            $count = 0;
            $main_percentage = 0;
            $grade = '';
            foreach($main as $dict)
            {
                $main_percentage += $dict['percentage'];
                $count += 1;
            }
            $main_percentage = $main_percentage/$count;
            if($main_percentage > 89)
            {
                $grade = 'A';
            }
            else if($main_percentage > 79 && $main_percentage < 90)
            {
                $grade = 'B';
            }
            else if($main_percentage > 69 && $main_percentage < 80)
            {
                $grade = 'C';
            }
            else if($main_percentage > 59 && $main_percentage < 70)
            {
                $grade = 'D';
            }
            return $grade;
        }
    }
}
