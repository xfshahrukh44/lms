<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentDashboardController extends Controller
{
    public function show(Request $request)
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
        return view('admin.dashboard.student_dashboard', compact('student', 'live_class_count'));
    }
}
