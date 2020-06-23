<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        $role = Role::all();
        return view('admin.user.user_list', compact('user', 'role'));
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
    public function store(Request $request)
    {
        $this->validate($request,[ 
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250',
            'role_id' => 'required',
        ]);
        $user = User::find($request->id);
        $role = Role::find($request->role_id);
        $user->syncRoles([$role]);
        User::find($id)->update($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $role = Role::where('id', $user->role_id)->get();
        return view('admin.user.user_detail',compact('user', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::all();
        
        $role_name = [];
        foreach($role as $roles){
            $role_name[$roles->id] = $roles->name;
        }
        $user = User::find($id);
        return view('admin.user.user_update',compact('user', 'role_name'));
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
        $this->validate($request,[ 
            'name' => 'required|string|max:250',
            'email' => 'required|string|max:250',
            'role_id' => 'required',
        ]);
        $user = User::find($id);
        $role = Role::find($request->role_id);
        $user->syncRoles([$role]);
        User::find($id)->update($request->all());
        return redirect()->route('user.index')->with('success','Record Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')->with('success','Record Deleted Successfully');
    }
}
