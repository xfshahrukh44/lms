<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\School;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classroom = Classroom::with('school', 'courses', 'sections')->get();
        return view('admin.classroom.classroom_list', compact('classroom'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classroom = Classroom::with('school', 'courses', 'sections')->get();
        $school = School::all();
        $school_name = [];
        foreach($school as $school)
        {
            $school_name[$school->id] = $school->title;
        }
        return view('admin.classroom.classroom_create', compact('classroom', 'school_name'));
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
            'school_id' => 'required'
        ]);
        $classroom = Classroom::create($request->all());
        return redirect()->route('classroom.index')->with('success','Classroom Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classroom = Classroom::find($id);
        return view('admin.classroom.classroom_detail', compact('classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classroom = Classroom::find($id);
        $school = School::all();
        $school_name = [];
        foreach($school as $school)
        {
            $school_name[$school->id] = $school->title;
        }
        return view('admin.classroom.classroom_update', compact('classroom', 'school_name'));
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
            'school_id' => 'required'
        ]);
        $classroom = Classroom::find($id)->update($request->all());
        return redirect()->route('classroom.show', $id)->with('message', 'Classroom updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Classroom::where('id', $id)->delete();
        return redirect()->route('classroom.index')->with('success','Classroom Deleted Successfully');
    }
}
