<?php

namespace App\Http\Controllers;

use App\Ideas;
use App\Ideas_img;
use App\Student;
use App\User;
use App\userinvitation;
use App\users1;
use Illuminate\Http\Request;

class UserAccesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listeInvitation=userinvitation::all();
        $users=users1::where('status',1)->get();
        return view('GestionAcces.table',compact('users','listeInvitation'));

    }
    public function create()
    {
        return view('GestionAcces.create');
    }

    public function SaveUser(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'=>'required'
        ]);

        $user=users1::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password' => bcrypt($request->password),
            'role'=>$request->role
        ]);
        return redirect()->route('ShowUser')->with('success','User Added');

    }
    public function AdminRole($id)
    {
        $user0=userinvitation::find($id);
        $user=users1::create([
            'name'=>$user0->name,
            'email'=>$user0->email,
            'password' =>$user0->password,
            'role'=>'Admin'
        ]);
        $user0->delete();
        return redirect()->route('ShowUser')->with('success','Admin Added');

    }
    public function UserRole($id)
    {
        $user0=userinvitation::find($id);
        $user=users1::create([
            'name'=>$user0->name,
            'email'=>$user0->email,
            'password' =>$user0->password,
            'role'=>'User'
        ]);
        $user0->delete();
        return redirect()->route('ShowUser')->with('success','User Added');
    }
    public function RefuserUser($id)
    {

        $user0=userinvitation::find($id);
        if(!$user0)
            return redirect()->back();
        $user0->delete();
        return redirect()->route('ShowUser')->with('success','User Refuser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'role'=>'required'
            ]);
        $users=users1::find($request->id);
        $users->name=$request->name;
        $users->role=$request->role;
        $users->save();

        return redirect()->route('ShowUser')->with('success','data Update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update($id){
        $users=users1::find($id);
        return view('GestionAcces.edit',compact('users'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $users=users1::find($id);
    if (!$users)
        return redirect()->back();

    $users->status = -1;
    $users->save();
    return redirect()->back()->with('success', 'Supression effectué');;
}
    public function getRoles()
    {
        $roles = $this->role_gestion->all();

        return view('GestionAcces.roles', compact('roles'));
    }
    public function all()
    {
        return $this->role->all();
    }
    public function postRoles(RoleRequest $request)
    {
        $this->role_gestion->update($request->except('_token'));

        return redirect('user/roles')->with('ok', trans('back/roles.ok'));
    }
}

