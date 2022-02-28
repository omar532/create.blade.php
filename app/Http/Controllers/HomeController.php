<?php

namespace App\Http\Controllers;
use App\Ideas;
use App\Student;
use App\User;
use App\userinvitation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = student::count();
        $user= User::count();
        return view('index',compact('count','user'));
    }
    public function Games()
    {
        return view('game');
    }
    public function QuizTable()
    {
        return view('QuizTable');
    }
    public function QuizAnimal()
    {
        return view('QuizAnimal');
    }
    public function QuizHistorique()
    {
        return view('QuizHistorique');
    }
    public function QuizScience()
    {
        return view('QuizScience');
    }
    public function QuizAll()
    {
        return view('Quiz');
    }
    public function testQuizAppel()
    {
        return view('apple');
    }
    public function NextQuiz2()
    {
        return view('ball');
    }
    public function ColerQuiz()
    {
        return view('RedQuizColor');
    }
    public function QuizSyllabe()
    {
        return view('QuizSyllabe');
    }
    public function QuizRep()
    {
        return view('test5');
    }
    public function QuizFormulaire()
    {
        return view('QuizFormulaire');
    }
    public function SaveQuiz(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'logo'=>'nbr'
        ]);
        $Ideas=Ideas::create([

            'title'=>$request->title,
            'nbr'=>$request->nbr

        ]);


        return view('QuizFormulaire');
    }
}
