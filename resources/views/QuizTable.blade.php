@extends('layouts.test')
@section('content')
    <style>
      @import url('https://fonts.googleapis.com/css?family=Lobster|Open+Sans');

        .quiz{
            background-image:url('https://wallpapercave.com/wp/wp2864000.gif');

            font-family: 'Open Sans', sans-serif;
        }
        .container {
            width: 750px;
        }
        .title {
            display: block;
            text-align: center;
        }

        .title h1 {
            font-family: 'Lobster', cursive;
            font-size: 55px;
            color: #DDDDDD;
        }

        .title h3 {
            color: #DDDDDD;
            font-family: 'Open Sans', sans-serif;
        }

        .btn1 > i {
            font-size: 40px;
        }

        .btn1 {
            background-color: #ffffff;
            border: 3px solid #DDDDDD;
            width: 150px;
            height: 150px;
            display: block;
            margin: 5px;
            text-align: center;
            font-family: 'Open Sans', sans-serif;
            font-size: 25px;
        }

        .btn1:hover {
            background-color: #DDDDDD;
        }

        #quiz_area {
            visibility: hidden;
            width: 650px;
            height: 450px;
            position: absolute;
            margin: auto;
            top: 15%;
            left: 20%;
        }

        .q-wrapper {
            background-color: #FFFFFF;
            border-radius: 3px;
            border: 3px solid #B10DC9;
            width: 350px;
            position: relative;
            left: 30%;
            text-align: center;
        }

        input {
            cursor: pointer;
        }

        .question {
            display: inline-block;
        }

        #num {
            padding: 5px;
            font-size: 45px;
            font-family: 'Lobster', cursive;
        }

        #question {
            margin: 10px;
            text-align: center;
            font-size: 20px;
        }

        #choices {
            margin: 5px;
            padding-left: 185px;
            font-size: 18px;
        }

        .answer {
            height: 50px;
            width: 350px;
            border-radius: 3px;
            border: 3px solid #B10DC9;
        }

        .answer:active, .answer.active {
            background-color: #DDDDDD;
        }

        .control {
            height: 45px;
            width: 100px;
            position: relative;
            top: 40%;
            left: 40%;
            background-color: #DDDDDD;
            margin: 5px;
            border: none;
            display: inline-block;
        }

        #results {
            font-family: 'Open Sans', sans-serif;
            visibility: hidden;
            text-align: center;
            background-color: #FFFFFF;
            border-radius: 3px;
            width: 550px;
            height: 250px;
            position: absolute;
            top: 25%;
            left: 30%;
        }

        #message {
            position: relative;
            top: 10%;
            text-align: center;
            vertical-align: middle;
            font-family: 'Lobster', cursive;
            font-size: 40px;
            font-weight: bold;
        }

        #reset {
            border-radius: 3px;
            background-color: #B10DC9;
            position: relative;
            top: 15%;
            left: 35%;
        }
    </style>

<div class="quiz">
<div class="wrapper" id="main">
    <div class="title align-text">
        <h1>QUIZZES</h1>
        <h3>PLAY NOW!</h3>
    </div>
    <center>
    <div class="container" id="column1">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('QuizAnimal')}}" ><img  style="width:150px;height: 150px;border-radius:500px;" src="{{asset('dist/img/animaux.jpg')}}"></img></a>
            </div>
            <div class="col-md-3">
                <a href="{{route('QuizAll')}}" ><img  style="width:150px;height: 150px;border-radius:500px;" src="{{asset('dist/img/quiz.jpg')}}"></img></a>
            </div>
            <div class="col-md-3">
                <a href="{{route('QuizFormulaire')}}" ><img  style="width:150px;height: 150px;border-radius:500px;" src="{{asset('dist/img/quiz3.jpg')}}"></img></a>
            </div>
        </div>
    </div>
        <br>
    <div class="container" id="column2">
        <div class="row">
            <div class="col-md-3">
                <a href="{{route('QuizHistorique')}}" ><img  style="width:150px;height: 150px;border-radius:500px;" src="{{asset('dist/img/hist.jpg')}}"></img></a>
            </div>

        </div>
    </div>
        <br>
    <div class="container" id="column3">
        <div class="row">
            <div class="col-md-3">
                    <a href="{{route('QuizScience')}}" ><img  style="width:150px;height: 150px;border-radius:500px;" src="{{asset('dist/img/science.jpg')}}"></img></a>
            </div>

        </div>
    </div>
   </center>
</div>
    <br>
<!-- Quiz questions -->
<div class="wrapper" id="quiz_area">
    <div id="image"><img id="qImg" src=""></div>
    <div class="q-wrapper">
        <h3 class="question" id="num"></h3>
        <p class="question" id="question"></p>
    </div>
    <div id="choices">
        <button class="btn1 answer" name="choice" id="choice0" value="0"></button>
        <button class="btn1 answer" name="choice" id="choice1" value="1"></button>
        <button class="btn1 answer" name="choice" id="choice2" value="2"></button>
        <button class="btn1 answer" name="choice" id="choice3" value="3"></button>
    </div>
    <ul class="pagination" id="pageItems">
            <li class="page-item" id="pageBack"><a class="page-link" href="#">Back</a>
            </li>
            <li class="page-item" id="pageNext"><a class="page-link" href="#">Next</a>
            </li>
    </ul>
</div>
<div class="wrapper" id="results">
    <h3 id="message"></h3>
    <button class="btn1" id="reset">Play Again</button>
</div>
</div>


    <script>

    </script>
@endsection