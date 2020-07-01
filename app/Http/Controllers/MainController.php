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
        if(auth()->user()->hasRole('admin'))
        {
            return redirect()->route('adminhome');
        }
        if(auth()->user()->hasRole('teacher'))
        {
            return redirect()->route('teacherhome');
        }
        if(auth()->user()->hasRole('student'))
        {
            return redirect()->route('studenthome');
        }
        if(auth()->user()->hasRole('guest'))
        {
            dd('aa');
            exit();
            return redirect()->route('guest');
        }
    }

    public function guest()
    {
        return view('home');
    }
}
