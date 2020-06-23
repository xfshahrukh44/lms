<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Program;
use Carbon\Carbon;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school = School::with('program', 'classrooms')->get();
        return view('admin.school.school_list', compact('school'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $school = School::with('program', 'classrooms')->get();
        $program_name = [];
        $programs = Program::all();
        foreach($programs as $program)
        {
            $program_name[$program->id] = $program->title;
        }
        return view('admin.school.school_create', compact('school', 'program_name'));
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
            'title' => 'string|required|max:100',
            'program_id' => 'required',
            'location' => 'string|max:500'
        ]);

        $school = School::create($request->all());
        return redirect()->route('school.index')->with('message', 'School created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = School::find($id);
        return view('admin.school.school_detail', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::find($id);
        $program_name = [];
        $programs = Program::all();
        foreach($programs as $program)
        {
            $program_name[$program->id] = $program->title;
        }
        return view('admin.school.school_update', compact('school', 'program_name'));
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
            'title' => 'string|required|max:100',
            'program_id' => 'required',
            'location' => 'string|max:500'
        ]);
        $school = School::find($id)->update($request->all());
        return redirect()->route('school.show', $id)->with('message', 'School updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        School::where('id', $id)->delete();
        return redirect()->route('school.index')->with('success','School Deleted Successfully');
    }
}
