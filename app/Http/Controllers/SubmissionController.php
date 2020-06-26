<?php

namespace App\Http\Controllers;
use App\Models\Submission;
use App\Models\Assignment;
use App\Models\Student;
use App\Models\Teacher;
use DB;
use Carbon\Carbon;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('teacher'))
        {
            $submission = Submission::all();
            return view('admin.submission.submission_list', compact('submission'));
        }
        if(auth()->user()->hasRole('student'))
        {
            $student =(Student::where('user_id', auth()->user()->id)->get())[0];
            $submission = Submission::where('student_id', $student->id)->get();
            return view('admin.submission.submission_list', compact('submission'));
        }
        {
            return redirect()->route('session.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(auth()->user()->hasRole('student'))
        {
            $submission = Submission::with('assignment', 'student')->get();
        
            $student = Student::where('user_id', auth()->user()->id)->get();
            $check = Submission::where('assignment_id', $request['assignment_id'] && 'student_id', $student[0]->id)->get();
            if(count($check) == 0)
            {
                $student_name = [];
                foreach($student as $student)
                {
                    $student_name[$student->id] = $student->name;
                }
        
                $assignment = Assignment::where('id', $request['assignment_id'])->get();
                $assignment_name = [];
                foreach($assignment as $assignment)
                {
                    $assignment_name[$assignment->id] = $assignment->title;
                }
        
                return view('admin.submission.submission_create', compact('submission', 'student_name', 'assignment_name'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->hasRole('student') || auth()->user()->hasRole('teacher'))
        {
            $this->validate($request, [
                'title' => 'required',
                'assignment_id' => 'required',
                'student_id' => 'required',
                'file' => 'required',
            ]);
            // dd($_FILES);
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
            
            $assignment = Assignment::find($request->assignment_id);
            $path = $request->file('file')->storeAs('public', auth()->user()->name.' - '.$assignment->session->course->title.' - '.$_FILES['file']['name']);
            DB::table('submissions')->insert([
                'title' => $request->title,
                'assignment_id' => $request->assignment_id,
                'student_id' => $request->student_id,
                'file' => $path,
                'marks' => $request->marks,
            ]);
            // Assignment::create($request->all());
            return redirect()->route('assignment.show', $request->assignment_id);
        }
        else
        {
            return redirect()->route('assignment.show', $request->assignment_id);
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
            $submission = Submission::find($id);
            return view('admin.submission.submission_detail', compact('submission'));
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($id);
            if($submission->assignment->session->teacher_id == $teacher[0]->id)
            {
                return view('admin.submission.submission_detail', compact('submission'));                
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
        if(auth()->user()->hasRole('student'))
        {
            $student = Student::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($id);
            if($submission->student_id == $student[0]->id)
            {
                return view('admin.submission.submission_detail', compact('submission'));
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
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($id);
            if($submission->assignment->session->teacher_id == $teacher[0]->id)
            {
                $student = Student::where('id', $submission->student_id)->get();
                $student_name = [];
                foreach($student as $student)
                {
                    $student_name[$student->id] = $student->name;
                }
        
                $assignment = Assignment::where('id', $submission->assignment_id)->get();
                $assignment_name = [];
                foreach($assignment as $assignment)
                {
                    $assignment_name[$assignment->id] = $assignment->title;
                }
                
                return view('admin.submission.submission_update', compact('submission', 'student_name', 'assignment_name'));
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
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($id);
            if($submission->assignment->session->teacher_id == $teacher[0]->id)
            {
                $this->validate($request, [
                    'marks' => 'required',
                ]);
                $submission = Submission::find($id)->update($request->all());
                return redirect()->route('submission.show', $id)->with('message', 'Submission updated successfully!');
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
            Submission::where('id', $id)->delete();
            return redirect()->route('submission.index')->with('success','Submission Deleted Successfully');
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
            $submission = Submission::find($request['submission_id']);
            return Storage::download($submission->file);
            // $file_contents = $submission->file;
            // return response($file_contents)
            //         ->header('Cache-Control', 'no-cache private')
            //         ->header('Content-Description', 'File Transfer')
            //         ->header('Content-Type', $submission->type)
            //         ->header('Content-length', strlen($file_contents))
            //         ->header('Content-Transfer-Encoding', 'binary');
        }
        if(auth()->user()->hasRole('teacher'))
        {
            $teacher = Teacher::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($request['submission_id']);
            if($submission->assignment->session->teacher_id == $teacher[0]->id)
            {
                return Storage::download($submission->file);
                // $file_contents = $submission->file;
                // return response($file_contents)
                //         ->header('Cache-Control', 'no-cache private')
                //         ->header('Content-Description', 'File Transfer')
                //         ->header('Content-Type', $submission->type)
                //         ->header('Content-length', strlen($file_contents))
                //         ->header('Content-Transfer-Encoding', 'binary');
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
        if(auth()->user()->hasRole('student'))
        {
            $student = Student::where('user_id', auth()->user()->id)->get();
            $submission = Submission::find($request['submission_id']);
            if($submission->student_id == $student[0]->id)
            {
                return Storage::download($submission->file);
                // $file_contents = $submission->file;
                // return response($file_contents)
                //         ->header('Cache-Control', 'no-cache private')
                //         ->header('Content-Description', 'File Transfer')
                //         ->header('Content-Type', $submission->type)
                //         ->header('Content-length', strlen($file_contents))
                //         ->header('Content-Transfer-Encoding', 'binary');
            }
            else
            {
                return redirect()->route('session.index');
            }
        }
    }

    public function unmarked_submissions()
    {
        if(auth()->user()->hasRole('teacher'))
        {
            $submission = [];
            $teacher = (Teacher::where('user_id', auth()->user()->id)->get())[0];
            foreach($teacher->sessions as $session)
            {
                foreach($session->assignments as $assignment)
                {
                    foreach($assignment->submissions as $submissions)
                    {
                        if($submissions->marks == NULL)
                        {
                            array_push($submission, $submissions);
                        }
                        else
                        {
                            continue;
                        }
                    }
                }
            }
            return view('admin.submission.submission_list', compact('submission'));
        }
        else
        {
            return redirect()->route('session.index');
        }
    }
}