<?php

namespace App\Http\Controllers;

use App\Images;
use App\StudentImage;
use App\Product;
use App\Student;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Image;
class ProductController extends Controller
{

    public function create()
    {
        $count = student::count();
        return view('student.create',compact('count'));
    }

    public function create1()
    {
        return view('create');
    }

    public function InputStudent(Request $request)
    {
        if($request->file('image')) {
            $image= $request->file('image');
            $filename = $image->getClientOriginalName();

            //Fullsize
            $image->move(public_path().'/full/',$filename);

            $image_resize = Image::make(public_path().'/full/'.$filename);
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('thumbnail/' .$filename));
            $StudentImage= new StudentImage();
            $StudentImage->student_id=$request->id;
            $StudentImage->path = "thumbnail/".$filename;
            $StudentImage->save();
            return redirect()->route('studentsList')->with('success',
                'Image Added');
        }
        return redirect()->back();
    }

    public function InputStudent1(Request $request)
    {
        $student=student::find($request->id);
        if($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();

            //Fullsize
            $image->move(public_path() . '/full/', $filename);

            $image_resize = Image::make(public_path() . '/full/' . $filename);
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('thumbnail/' . $filename));
            $student->image = "thumbnail/".$filename;
        }

        $student->first_name=$request->first_name;
        $student->last_name = $request->last_name;


        $student->save();
        return redirect()->route('studentsList')->with('success',
            'data Added');
    }

    public function handleAddProduct(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'image'=>'required',

        ]);

        $image       = $request->file('image');
        $filename    = $image->getClientOriginalName();

        //Fullsize
        $image->move(public_path().'/full/',$filename);

        $image_resize = Image::make(public_path().'/full/'.$filename);
        $image_resize->fit(300, 300);
        $image_resize->save(public_path('thumbnail/' .$filename));

        $student=student::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'image'=>'thumbnail/'.$filename
        ]);

        if($request->file('images')){

            $this->images($request->file('images'),$student->id);
        }


        return redirect()->route('studentsList')->with('success',
            'data Added');

    }
    public function images ($images,$studentId){
        foreach ($images as $image){
            $filename = $image->getClientOriginalName();
            $image->move(public_path().'/full/',$filename);
            $image_resize = Image::make(public_path().'/full/'.$filename);
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('thumbnail/' .$filename));
            $StudentImage =  StudentImage::create([
                'student_id'=>$studentId,
                'path'=>'thumbnail/'.$filename
            ]);

        }
        return redirect()->route('studentsList')->with('success',
            'User Added');
    }
    function fetch_image($image_id)
    {
        $image = Images::findOrFail($image_id);

        $image_file = Image::make($image->user_image);

        $response = Response::make($image_file->encode('jpeg'));

        $response->header('Content-Type', 'image/jpeg');

        return $response;
    }

}
