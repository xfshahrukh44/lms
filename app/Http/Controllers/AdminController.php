<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Session;
use App\Models\Submission;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function view_dashboard(Request $request)
    {
        $session = Session::all();
        $section = Section::all();
        // dd($session);
        // exit();

        //assignments
        $assignment_count = 0;
        foreach($session as $session1)
        {
            foreach($session1->assignments as $asgn)
            {
                $assignment_count += 1;
            }
        }
        
        //your submissions
        $submission = Submission::all();
        $submission_count = count($submission);

        //live classes
        $live_class_count = 0;
        foreach($session as $session2)
        {
            if($session2->state == "enable")
            {
                $live_class_count += 1;
            }
        }
        

        //time spent this month
        $attendances = Attendance::where('user_id', auth()->user()->id)
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

        return view('admin.dashboard.admin_dashboard', compact('assignment_count', 'submission_count', 'live_class_count', 'wh','check','total_days'));
    }
}
