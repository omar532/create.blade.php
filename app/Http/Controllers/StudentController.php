<?php

namespace App\Http\Controllers;

use App\StudentImage;
use App\Product;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Student;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class StudentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=student::all();
        return view('new',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $count = student::count();
        return view('student.create');
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
            'first_name' =>'required',
            'last_name' =>'required'
        ]);


        $image       = $request->file('image');
        $filename    = $image->getClientOriginalName();

        //Fullsize
        $image->move(public_path().'/full/',$filename);

        $image_resize = Image::make(public_path().'/full/'.$filename);
        $image_resize->fit(300, 300);
        $image_resize->save(public_path('thumbnail/' .$filename));

        $student= new student();
        $student->name = $request->name;
        $student->image = $filename;
        $student->save();


            return redirect()->route('studentsList')->with('success',
                'data Added');



             }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */



    public function show($id)
    {

        $student=Student::find($id);
        $images=StudentImage::where('student_id',$id)->where('status',1)->get();
        if(!$student)
            return redirect()->back();

        return view('update',compact('student','images'));
    }
    public function show1($id)
    {
        $student=Student::find($id);
        if(!$student)
            return redirect()->back();
        $user=Student::find($id);
        if(!$user)
            return redirect()->back();

        return view('update',compact('user'),compact('student'));
    }



    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
   /* public function authenticated (Request $request)
    {
        $this->validate($request,[
            'pseudo' =>'required',
            'pass' =>'required'
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }
            $pseudo=$request->pseudo;
            $pass=$request->password;
           if((['pseudo'=>$pseudo,'pass'=>$pass]))
           {
                return redirect()->route('studentsList')->with('success','connection successfully');
           }

           return Redirect::to('users');*/
/*
    $user =users::find($name,$password);
     if(!$user)
        return redirect()->back();

    $student = DB::select('select * from students');
    }

    */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id) {

         $this->validate($request,[
            'first_name' =>'required',
            'last_name' =>'required',
             'image' =>'required'
        ]);

    $student=Student::find($id);
    if(!$student)
        return redirect()->back();

    $student->first_name=$request->first_name;
    $student->last_name=$request->last_name;
    $student->image=$request->image;
    $student->save();
    
    return redirect()->route('studentsList')->with('success','updated successfully');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
           $student=Student::find($id);
    if(!$student)
        return redirect()->back();

        $student->delete();
        
        return redirect()->back()->with('success','Supression effectué');;

    }
    public function archive($id)
    {
        $images=StudentImage::find($id);
        if(!$images)
            return redirect()->back();

        $images->status = -1;
        $images->save();
        return redirect()->back()->with('success','Supression effectué');;

    }
    public function Inp($id)
    {
        $student=Student::find($id);
        if(!$student)
            return redirect()->back();

        return view('Input',compact('student'));
    }
    public function Inp1($id)
    {
        $student=Student::find($id);
        if(!$student)
            return redirect()->back();

        return view('Input1',compact('student'));
    }
    public function UpdateName($id)
    {
        $student=Student::find($id);
        if(!$student)
            return redirect()->back();
        return view('Input1',compact('student'));
    }

    public function Input(Request $request, $date_timestamp_get)
    {
        $image       = $request->file('image');
        $filename    = $image->getClientOriginalName();

        //Fullsize
        $image->move(public_path().'/full/',$filename);
        $image_resize = Image::make(public_path().'/full/'.$filename);
        $image_resize->fit(300, 300);
        $image_resize->save(public_path('thumbnail/' .$filename));
        $student= new student();
        $student->student_id = $request->id;
        $student->path = $filename;
        $student->created_at = $request->created_at;

        $student->save();
        return redirect()->route('studentsList')->with('success',
            'data Added');
    }
    public function handleAddProduct(Request $request)
    {


        $image       = $request->file('image');
        $filename    = $image->getClientOriginalName();

        //Fullsize
        $image->move(public_path().'/full/',$filename);

        $image_resize = Image::make(public_path().'/full/'.$filename);
        $image_resize->fit(300, 300);
        $image_resize->save(public_path('thumbnail/' .$filename));

        $student= new student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->image = $filename;
        $student->save();

        return back()->with('success', 'Your product saved with image!!!');
    }
}
