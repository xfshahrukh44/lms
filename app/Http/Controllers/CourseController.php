<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Classroom;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $course = Course::with('classroom', 'sessions')->get();
        return view('admin.course.course_list', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $course = Course::with('classroom', 'sessions')->get();
        $classroom = Classroom::all();
        $classroom_name = [];
        foreach($classroom as $classroom)
        {
            $classroom_name[$classroom->id] = $classroom->title;
        }
        return view('admin.course.course_create', compact('course', 'classroom_name'));
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
            'title' => 'required|string|max:100',
            'classroom_id' => 'required'
        ]);
        $course = Course::create($request->all());
        return redirect()->route('course.index')->with('success','Course Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        return view('admin.course.course_detail', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        $classroom = Classroom::all();
        $classroom_name = [];
        foreach($classroom as $classroom)
        {
            $classroom_name[$classroom->id] = $classroom->title;
        }
        return view('admin.course.course_update', compact('course', 'classroom_name'));
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
            'title' => 'required|string|max:100',
            'classroom_id' => 'required'
        ]);
        $course = Course::find($id)->update($request->all());
        return redirect()->route('course.show', $id)->with('message', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::where('id', $id)->delete();
        return redirect()->route('course.index')->with('success','Course Deleted Successfully');
    }
}
