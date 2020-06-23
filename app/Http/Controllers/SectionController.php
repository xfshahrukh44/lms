<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Classroom;
use App\Models\Course;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section = Section::with('classroom', 'students', 'sessions')->get();
        return view('admin.section.section_list', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $section = Section::with('classroom', 'students', 'sessions')->get();
        $classroom = Classroom::all();
        $classroom_name = [];
        foreach($classroom as $classroom)
        {
            $classroom_name[$classroom->id] = $classroom->title;
        }
        return view('admin.section.section_create', compact('section', 'classroom_name'));
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
        $section = Section::create($request->all());
        return redirect()->route('section.index')->with('success','Section Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);
        $courses = Course::where('classroom_id', $section->classroom->id)->get();

        return view('admin.section.section_detail', compact('section', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::find($id);
        $classroom = Classroom::all();
        $classroom_name = [];
        foreach($classroom as $classroom)
        {
            $classroom_name[$classroom->id] = $classroom->title;
        }
        return view('admin.section.section_update', compact('section', 'classroom_name'));
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
        $section = Section::find($id)->update($request->all());
        return redirect()->route('section.show', $id)->with('message', 'Section updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Section::where('id', $id)->delete();
        return redirect()->route('section.index')->with('success','Section Deleted Successfully');
    }
}
