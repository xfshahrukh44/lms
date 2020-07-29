<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use DB;
use Carbon\Carbon;
use Auth;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attendance = DB::table('attendances')
        ->join('users', 'attendances.user_id','=', 'users.id')
        ->select('attendances.id','attendances.check_in','attendances.check_out','users.name AS user_name')
        ->where('attendances.user_id', auth()->user()->id)
        ->paginate(10);

        return view('admin.attendance.attendance_list', compact('attendance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        // $attendance_count = Attendance::where('user_id', auth()->user()->id)->get();
        // if(count($attendance_count) == 0)
        // {
        //     Attendance::create([
        //         'user_id' => $id,
        //     ]);
        //     return redirect()->route('session.index');
        // }
        // else
        // {
        //     return redirect()->route('session.index');
        // }
    }

    public function check_in(Request $request)
    {
        Attendance::create([
            'user_id' => auth()->user()->id,
            'check_in' => Carbon::now()->addHours(5),
        ]);
        $check_in = Carbon::now()->addHours(5);
        echo ($check_in);    
    }

    public function check_out(Request $request)
    {
        DB::table('attendances')
            ->where('user_id',auth()->user()->id)
            ->where('check_in','>',Carbon::today())
            ->update(['check_out' => Carbon::now()->addHours(5)]); 
    }

    public function find_check_in_out_status(Request $request)
    {
        $status = DB::table('attendances')
            ->where('user_id',auth()->user()->id)
            ->where('check_in','>',Carbon::today())
            ->get();
        echo json_encode($status);      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attendance_count = Attendance::where('user_id', auth()->user()->id)->get();
        if(count($attendance_count) == 0)
        {
            Attendance::create([
                'user_id' => $id,
            ]);
            return redirect()->route('session.index');
        }
        else
        {
            return redirect()->route('session.index');
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
        if(!$this->checkPermission())
            return redirect('home');

        $attendance = Attendance::find($id);
        return Response::json($attendance);
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
        Attendance::find($request->attendance_id)->update($request->all());

        return redirect()->route('attendance.index')->with('success','Record Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
