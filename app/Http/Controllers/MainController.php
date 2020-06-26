<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function dashboard()
    {
        if(auth()->user() == NULL)
        {
            return redirect()->route('login');
        }
        else if(auth()->user()->hasRole('admin'))
        {
            return redirect()->route('adminhome');
        }
        else if(auth()->user()->hasRole('teacher'))
        {
            return redirect()->route('teacherhome');
        }
        else if(auth()->user()->hasRole('student'))
        {
            return redirect()->route('studenthome');
        }
    }

    public function guest()
    {
        return view('home');
    }
}
