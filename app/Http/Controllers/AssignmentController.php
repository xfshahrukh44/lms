<?php

namespace App\Http\Controllers;
use App\Models\Assignment;
use App\Models\Session;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Submission;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class AssignmentController extends Controller
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
            $assignment = Assignment::with('session')->get();
            return view('admin.assignment.assignment_list', compact('assignment'));
        }
        if(auth()->user()->hasRole('student'))
        {
            $assignment = [];
            $student = Student::where('user_id', auth()->user()->id)->get();
            $section = Section::find($student[0]->section_id);
            foreach($section->sessions as $session)
            {
                foreach($session->assignments as $asgn)
                {
                    $check = Submission::where('student_id', $student[0]->id && 'assignment_id', $asgn->id)->get();
                    if(count($check) == 0)
                    {
                        array_push($assignment, $asgn);
                    }
                    else
                    {
                        continue;
                    }
                }
            }
            return view('admin.assignment.assignment_list', compact('assignment'));

        }
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];
            $assignment = [];
            foreach($teacher->sessions as $session)
            {
                foreach($session->assignments as $assignments)
                {
                    array_push($assignment, $assignments);
                }
            }
            return view('admin.assignment.assignment_list', compact('assignment'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('admin'))
        {
            $assignment = Assignment::with('session')->get();
            $session = Session::where('id', $request['session_id'])->get();
            $session_name = [];
            foreach($session as $session)
            {
                $session_name[$session->id] = $session->course->title." - ".$session->course->classroom->title." - ".$session->section->title;
            }
            return view('admin.assignment.assignment_create', compact('assignment', 'session_name'));
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
        if(auth()->user()->hasRole('teacher'))
        {
            $this->validate($request, [
                'session_id' => 'required',
                'title' => 'required',
                'marks' => 'required',
            ]);
            // $type = $_FILES['file']['type'];
            // $data = file_get_contents($_FILES['file']['tmp_name']);

            //Purging Files Code Start//
            $assignment = Assignment::all();
            if(count($assignment) > 100){
                for($i = 0; $i < 10; $i++){
                    Storage::delete($assignment[$i]->file);
                    Assignment::where('id', $assignment[$i]->id)->delete();
                }
            }
            //Purging Files Code End//

            $session = Session::find($request->session_id);
            // dd(auth()->user()->name);
            // exit();
            $path = $request->file('file')->storeAs('public', auth()->user()->name.' - '.$session->course->title.' - '.$_FILES['file']['name']);
            DB::table('assignments')->insert([
                'session_id' => $request->session_id,
                'title' => $request->title,
                'description' => $request->description,
                'marks' => $request->marks,
                'file' => $path,
            ]);
            return redirect()->route('session.show', $request->session_id);
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
            $assignment = Assignment::find($id);
            return view('admin.assignment.assignment_detail', compact('assignment'));
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $assignment = Assignment::find($id);
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            if($assignment->session->teacher_id == $teacher[0]->id)
            {
                return view('admin.assignment.assignment_detail', compact('assignment'));
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
        if(auth()->user()->hasRole('student'))
        {
            $assignment = Assignment::find($id);
            $student = Student::where('user_id', auth()->user()->id)->get();
            if($assignment->session->section_id == $student[0]->section_id)
            {
                return view('admin.assignment.assignment_detail', compact('assignment'));
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
        if(auth()->user()->hasRole('admin'))
        {
            $assignment = Assignment::find($id);
            $session = Session::all();
            $session_name = [];
            foreach($session as $session)
            {
                $session_name[$session->id] = $session->course->title." - ".$session->course->classroom->title." - ".$session->section->title;
            }
            return view('admin.assignment.assignment_update', compact('assignment', 'session_name'));            
        }
        else if(auth()->user()->hasRole('teacher'))
        {
            $assignment = Assignment::find($id);
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            if($assignment->session->teacher_id == $teacher[0]->id)
            {
                $assignment = Assignment::find($id);
                $session = Session::all();
                $session_name = [];
                foreach($session as $session)
                {
                    $session_name[$session->id] = $session->course->title." - ".$session->course->classroom->title." - ".$session->section->title;
                }
                return view('admin.assignment.assignment_update', compact('assignment', 'session_name'));
            }
            else
            {
                return redirect()->route('session.index');
            }
            
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
        if(auth()->user()->hasRole('admin'))
        {
            $this->validate($request, [
                'session_id' => 'required',
                'title' => 'required',
                'marks' => 'required',
            ]);
            $assignment = Assignment::find($id)->update($request->all());
            return redirect()->route('assignment.show', $id)->with('message', 'Assignment updated successfully!');
        }

        else if(auth()->user()->hasRole('teacher'))
        {
            $assignment = Assignment::find($id);
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            if($assignment->session->teacher_id == $teacher[0]->id)
            {
                $this->validate($request, [
                    'session_id' => 'required',
                    'title' => 'required',
                    'marks' => 'required',
                ]);
                $assignment = Assignment::find($id)->update($request->all());
                return redirect()->route('assignment.show', $id)->with('message', 'Assignment updated successfully!');
            }
            else
            {
                return redirect()->route('session.index');
            }
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
            Assignment::where('id', $id)->delete();
            return redirect()->route('assignment.index')->with('success','Assignment Deleted Successfully');
        }
        else if(auth()->user()->hasRole('teacher'))
        {
            $assignment = Assignment::find($id);
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            if($assignment->session->teacher_id == $teacher[0]->id)
            {
                Assignment::where('id', $id)->delete();
                return redirect()->route('assignment.index')->with('success','Assignment Deleted Successfully');
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
        
        else
        {
            return redirect()->route('session.index');
        }
    }

    public function download(Request $request)
    {

        if(auth()->user()->hasRole('admin'))
        {
            $assignment = Assignment::find($request['assignment_id']);
            $file_contents = $assignment->file;
            return Storage::download($assignment->file);
            // return response($file_contents)
            //     ->header('Cache-Control', 'no-cache private')
            //     ->header('Content-Description', 'File Transfer')
            //     ->header('Content-Type', $assignment->type)
            //     ->header('Content-length', strlen($file_contents))
            //     ->header('Content-Transfer-Encoding', 'binary');
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $assignment = Assignment::find($request->assignment_id);
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            if($assignment->session->teacher_id == $teacher[0]->id)
            {
               return Storage::download($assignment->file);
                // $assignment = Assignment::find($request['assignment_id']);
                // $file_contents = $assignment->file;
                // return response($file_contents)
                // ->header('Cache-Control', 'no-cache private')
                // ->header('Content-Description', 'File Transfer')
                // ->header('Content-Type', $assignment->type)
                // ->header('Content-length', strlen($file_contents))
                // ->header('Content-Transfer-Encoding', 'binary');
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
        
        if(auth()->user()->hasRole('student'))
        {
            $assignment = Assignment::find($id);
            $student = Student::where('user_id', auth()->user()->id)->get();
            if($assignment->session->section_id == $student[0]->section_id)
            {
                return view('admin.assignment.assignment_detail', compact('assignment'));
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
    }
}