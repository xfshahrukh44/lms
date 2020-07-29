<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{
    public function dashboard()
    {
        if(auth()->user() == NULL)
        {
            return redirect()->route('login');
        }
        elseif(auth()->user()->hasRole('admin'))
        {
            return redirect()->route('adminhome');
        }
        elseif(auth()->user()->hasRole('teacher'))
        {
            return redirect()->route('teacherhome');
        }
        elseif(auth()->user()->hasRole('student'))
        {
            return redirect()->route('studenthome');
        }
        else
        {
            return redirect()->route('guest');
        }
    }

    public function guest()
    {
        return view('home');
    }
}
