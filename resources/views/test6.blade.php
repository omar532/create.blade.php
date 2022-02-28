@extends('layouts.test')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://jchamill.github.io/jquery-quiz/jquery.quiz-min.js"></script>

    <style>
        body, html{
            font-family: arial;
            margin: 0;
            background: url('http://www.planwallpaper.com/static/images/website-background-pattern.jpg');
            background-size: cover;

        }

        img{max-width: 100%;}

        .quiz{
            margin: 0 auto;
            text-align: center;
            max-width: 320px;
            opacity: 0;
            padding-right: 0.975em;
            padding-left: 0.975em;
        }

        #question{
            margin: 0.5rem auto;
            font-weight: bold;
        }

        .answer-button {
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background-color: #39b1ff;
            background-image: linear-gradient(to top, #2c8fff, ##4cc2ff);
            padding: 10px;
            font-size: 16px;
            color: white;
            font-weight: bold;
            outline: none;
            margin: 0 auto 0.5rem;
            display: block;
            cursor:pointer;
        }

        .pulse{
            animation: pulse 0.7s both ease-in-out 1;
        }

        @keyframes pulse {
            0% { transform: scale3d(1,1,1); }
            50% { transform: scale3d(0.98,0.98,1); }
            100% { transform: scale3d(1,1,1);}
        }


        #score{
            display: none;
        }
    </style>
    <div class="quiz">
        <div id="image"><img id="qImg" src=""></div>
        <div id="question"></div>
        <div id="answers"></div>
    </div>
    <div id="score"></div>
   <script>
       var questionNumber = 0;
       var totalScore = 0;
       var question;
       var totalAnswers;
       var correctAnswer;
       var quizLength;
       var quizItems = [
           {
               "qImg": "https://www.keralatourism.org/images/img-gallery-07.jpg",
               "question": "Who won an Oscar for best movie?",
               "answers": ["La La Land", "Moonlight"],
               "correct": "1"
           },
           {
               "qImg":"https://www.keralatourism.org/images/img-gallery-09.jpg",
               "question": "What is the answer to question 2?",
               "answers": ["wrong", "right", "don't know"],
               "correct": "2"
           },
           {
               "qImg":"https://assets1.ignimgs.com/2015/03/12/redoutscreenshot00229jpg-57ab43_320w.jpg",
               "question": "What is the answer to question 3?",
               "answers": ["wrong", "right", "don't know","maybe","I give up"],
               "correct": "4"
           }
       ];

       $(document).ready(function(){
           nextQuestion();
       });

       function nextQuestion(){
           quizLength = quizItems.length;
           if(questionNumber  == quizLength){ //END OF QUIZ; FOLLOW UP IN HERE
               $('.quiz').fadeOut(function(){
                   setTimeout(function(){
                       $('#score').html("Your total score: " + totalScore).fadeIn(); //Score is optional
                   },500);
               });
           } else {
               $('#question, #answers').html('');
               $('#qImg').attr('src','');
               question = quizItems[questionNumber]['question'];
               qImg = quizItems[questionNumber]['qImg'];
               totalAnswers = quizItems[questionNumber].answers.length;
               correctAnswer = quizItems[questionNumber]['correct'];
               if (qImg !== "") {
                   $('#qImg').attr('src',qImg).show();
               } else {
                   $('#qImg').hide();
               }
               $('#question').text(question);
               for(i=0;i<totalAnswers;i++){
                   $('#answers').append('<div id="'+ i +'" class="answer-button">'+quizItems[questionNumber].answers[i]+'</div>');
               }
               $('.quiz').fadeTo(500,1);
               $(".answer-button").on('click',answerQuestion);
               pulseClick(0);
           }
       }

       function answerQuestion(){
           $(".answer-button").off('click',answerQuestion);
           var a = this.id;
           console.log("Your answer: "+ a +"; The correct answer: " + correctAnswer);
           checkScore(a); // Checking the score on your click.
           questionNumber++;
           $('.quiz').fadeTo(500,0, function(){
               nextQuestion();
           });
       }

       function checkScore(a){ // Checking your score here
           console.log("Your answer to check: "+ a);
           if(a === correctAnswer){
               console.log("Right answer!");
               totalScore +=10;
               console.log("The score: "+ totalScore);
           } else{
               console.log("Wrong answer!");
               console.log("The score: "+ totalScore);
           }
       }

       function pulseClick(i){
           var btnCount = $('#answers').find('.answer-button').length-1;
           console.log(btnCount);
           $('#answers').find('.answer-button').eq(i).addClass('pulse').one('webkitAnimationEnd oanimationend msAnimationEnd animationend',function(e) {
               $(this).removeClass('pulse');
               if(i === btnCount){
                   i=0;
               } else {
                   i++;
               }
               pulseClick(i);
           });
       }
   </script>
@endsection