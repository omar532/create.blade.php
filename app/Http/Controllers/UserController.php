<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getData(Request $req){
    	
    	print_r($req->input());

    }

    public function show(Request $request,$id) {

         $this->validate($request,[
            'first_name' =>'required',
            'last_name' =>'required'
        ]);  

    $student=Student::find($id);
    if(!$student)
        return redirect()->back();

    
    return redirect()->route('studentsList')->with('success','Connection successfully');

}
       
    
}
