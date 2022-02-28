<?php

namespace App\Http\Controllers;

use App\Ideas;
use App\Ideas_img;
use App\Images;
use App\Student;
use App\StudentImage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class IdeasController extends Controller
{
    public function index ()
    {
    $ideas=Ideas::where('status',1)->get();
        return view('widgets',compact('ideas'));
    }


    public function addIdea(Request $request){
        $this->validate($request,[
        'address'=>'required',
        'lat'=>'required',
        'lng'=>'required',
        'title'=>'required',
        'logo'=>'required'
    ]);
        $image      = $request->file('logo');
        $filename    = $image->getClientOriginalName();
        $image->move(public_path().'/full/',$filename);
        $image_resize =Image::make(public_path().'/full/'.$filename);
        $image_resize->fit(300, 300);
        $image_resize->save(public_path('thumbnail/' .$filename));

        $Ideas=Ideas::create([
            'address'=>$request->address,
            'latitude'=>$request->lat,
            'longitude'=>$request->lng,
            'title'=>$request->title,
            'logo'=>'thumbnail/'.$filename
        ]);

        if($request->file('logos')){

            $this->logos($request->file('logos'),$Ideas->id);
        }
        return redirect()->route('ShowMap')->with('success','Ideas Added');
    }
    public function logos ($logos,$ideastId){
        foreach ($logos as $logo){
            $filename = $logo->getClientOriginalName();
            $logo->move(public_path().'/full/',$filename);
            $image_resize = Image::make(public_path().'/full/'.$filename);
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('thumbnail/' .$filename));
            $Ideas_img =  Ideas_img::create([
                'ideas_id'=>$ideastId,
                'path'=>'thumbnail/'.$filename
            ]);

        }
        return redirect()->route('ShowMap')->with('success','Ideas Added');
    }

    public function getIdeasList(){
        $ideas=Ideas::where('status',1)->get();

        return view('ListeIdeas',compact('ideas'));

    }
    public function showIdeas($id){
        $ideas=Ideas::find($id);
        $ideas_img=Ideas_img::where('ideas_id',$id)->where('status',1)->get();
        return view('updateideas',compact('ideas','ideas_img'));
    }
    public function deleteIdea($id){
        $ideas=Ideas::find($id);
        $ideas_img=Ideas_img::where('ideas_id',$id)->get();
        if(!$ideas)
            return redirect()->back();
        if($ideas_img){
            foreach ($ideas_img as $ideasWhere) {
                $ideasWhere->status = -1;
                $ideasWhere->save();
            }}
        $ideas->status = -1;
        $ideas->save();
        return redirect()->back()->with('success','Supression effectué');;

    }

    public function UpIdeas($id){
    $ideas=Ideas::find($id);
    if(!$ideas)
        return redirect()->back();
    return view('ideasupdate1',compact('ideas'));
    }
    public function Archives($id)
            {
                $ideas_img =Ideas_img::find($id);
                if (!$ideas_img)
                    return redirect()->back();

                $ideas_img->status = -1;
                $ideas_img->save();
                return redirect()->back()->with('success', 'Supression effectué');;
            }

    public function UpdateIdeas(Request $request)
    {
        $this->validate($request,[
            'address'=>'required',
            'title'=>'required',
        ]);
        $Ideas = Ideas::find($request->id);
        if ($request->file('image')) {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path() . '/full/', $filename);
            $image_resize = Image::make(public_path() . '/full/' . $filename);
            $image_resize->fit(300, 300);
            $image_resize->save(public_path('thumbnail/' . $filename));
            $Ideas->logo = "thumbnail/" . $filename;
        }
        $Ideas->address = $request->address;
        $Ideas->title = $request->title;
        $Ideas->save();
        return redirect()->route('getIdeasList')->with('success', 'data Update');
    }
}
