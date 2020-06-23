<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Section;
use Auth;

class SessionController extends Controller
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
            $session = Session::with('course', 'teacher', 'section', 'assignments')->get();
            return view('admin.session.session_list', compact('session'));
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $session = Session::where('teacher_id', $teacher[0]->id)->with('course', 'teacher', 'section', 'assignments')->get();
            return view('admin.session.session_list', compact('session'));
        }
        if(auth()->user()->hasRole('student'))
        {
            $student = Student::where('user_id', auth()->user()->id)->get();
            $session = Session::where('section_id', $student[0]->section->id)->with('course', 'teacher', 'section', 'assignments')->get();
            return view('admin.session.session_list', compact('session'));
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
            $session = Session::with('course', 'teacher', 'section', 'assignments')->get();

            $course = Course::all();
            $course_name = [];
            foreach($course as $course)
            {
                $course_name[$course->id] = $course->classroom->title." - ".$course->title;
            }

            $teacher = Teacher::all();
            $teacher_name = [];
            foreach($teacher as $teacher)
            {
                $teacher_name[$teacher->id] = $teacher->name;
            }

            $section = Section::all();
            $section_name = [];
            foreach($section as $section)
            {
                $section_name[$section->id] = $section->classroom->title." - ".$section->title;
            }
            
            return view('admin.session.session_create', compact('session', 'course_name', 'teacher_name', 'section_name'));
        }

        else
        {
            return redirect()->route('session.index');
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
                'section_id' => 'required',
                'course_id' => 'required',
                'teacher_id' => 'required',
                'meeting_url' => 'nullable',
                'state' => 'required',
            ]);
            $session = Session::create($request->all());
            return redirect()->route('session.index')->with('success','Session Created Successfully');
        }

        else
        {
            return redirect()->route('session.index');
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
            $session = Session::with('section', 'course', 'teacher', 'assignments')->find($id);
            return view('admin.session.session_detail', compact('session'));
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $session = Session::find($id);
            if($teacher[0]->id == $session->teacher_id)
            {
                return view('admin.session.session_detail', compact('session'));
            }
            else
            {
                return redirect()->route('session.index');
            }
        }

        if(auth()->user()->hasRole('student'))
        {
            $student = Student::where('user_id', auth()->user()->id)->get();
            $session = Session::find($id);
            if($session->section_id == $student[0]->section_id)
            {
                return view('admin.session.session_detail', compact('session'));
            }
            else
            {
                return redirect()->route('session.index');
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
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
        {
            $session = Session::find($id);

            $course = Course::where('id', $session->course_id)->get();
            $course_name = [];
            foreach($course as $course)
            {
                $course_name[$course->id] = $course->classroom->title." - ".$course->title;
            }

            $teacher = Teacher::where('id', $session->teacher_id)->get();
            $teacher_name = [];
            foreach($teacher as $teacher)
            {
                $teacher_name[$teacher->id] = $teacher->name;
            }

            $section = Section::where('id', $session->section_id)->get();
            $section_name = [];
            foreach($section as $section)
            {
                $section_name[$section->id] = $section->classroom->title." - ".$section->title;
            }

            return view('admin.session.session_update', compact('session', 'course_name', 'teacher_name', 'section_name'));
        }
        else
        {
            return redirect()->route('session.index');
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
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
        {
            $this->validate($request, [
                'meeting_url' => 'nullable',
                'state' => 'required',
            ]);
            $session = Session::find($id)->update($request->all());
            return redirect()->route('session.show', $id)->with('message', 'Session updated successfully!');
        }
        else
        {
            return redirect()->route('session.index');
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
            Session::where('id', $id)->delete();
            return redirect()->route('session.index')->with('success','Session Deleted Successfully');
        }
        else
        {
            return redirect()->route('session.index');
        }
    }
}
