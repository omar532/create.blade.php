@extends('layouts.test')

@section('content')
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quiz</title>
    <!-- jquery for maximum compatibility -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        /** Simple JavaScript Quiz
         * version 0.1.0
         * http://journalism.berkeley.edu
         * created by: Jeremy Rue @jrue
         *
         * Copyright (c) 2013 The Regents of the University of California
         * Released under the GPL Version 2 license
         * http://www.opensource.org/licenses/gpl-2.0.php
         * This program is distributed in the hope that it will be useful, but
         * WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
         */

        var quiztitle = "Quiz Title";

        /**
         * Set the information about your questions here. The correct answer string needs to match
         * the correct choice exactly, as it does string matching. (case sensitive)
         *
         */
        var quiz = [
            {
                "question"      :   "Q1: Who came up with the theory of relativity?",
                "image"         :   "http://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Albert_Einstein_Head.jpg/220px-Albert_Einstein_Head.jpg",
                "choices"       :   [
                    "Sir Isaac Newton",
                    "Nicolaus Copernicus",
                    "Albert Einstein",
                    "Ralph Waldo Emmerson"
                ],
                "correct"       :   "Albert Einstein",
                "explanation"   :   "Albert Einstein drafted the special theory of relativity in 1905.",
            },
            {
                "question"      :   "Q2: Who is on the two dollar bill?",
                "image"         :   "http://upload.wikimedia.org/wikipedia/commons/thumb/9/94/US_%242_obverse-high.jpg/320px-US_%242_obverse-high.jpg",
                "choices"       :   [
                    "Thomas Jefferson",
                    "Dwight D. Eisenhower",
                    "Benjamin Franklin",
                    "Abraham Lincoln"
                ],
                "correct"       :   "Thomas Jefferson",
                "explanation"   :   "The two dollar bill is seldom seen in circulation. As a result, some businesses are confused when presented with the note.",
            },
            {
                "question"      :   "Q3: What event began on April 12, 1861?",
                "image"         :   "",
                "choices"       :   [
                    "First manned flight",
                    "California became a state",
                    "American Civil War began",
                    "Declaration of Independence"
                ],
                "correct"       :   "American Civil War began",
                "explanation"   :   "South Carolina came under attack when Confederate soldiers attacked Fort Sumter. The war lasted until April 9th 1865.",
            },

        ];


        /******* No need to edit below this line *********/
        var currentquestion = 0, score = 0, submt=true, picked;

        jQuery(document).ready(function($){

            /**
             * HTML Encoding function for alt tags and attributes to prevent messy
             * data appearing inside tag attributes.
             */
            function htmlEncode(value){
                return $(document.createElement('div')).text(value).html();
            }

            /**
             * This will add the individual choices for each question to the ul#choice-block
             *
             * @param {choices} array The choices from each question
             */
            function addChoices(choices){
                if(typeof choices !== "undefined" && $.type(choices) == "array"){
                    $('#choice-block').empty();
                    for(var i=0;i<choices.length; i++){
                        $(document.createElement('li')).addClass('choice choice-box').attr('data-index', i).text(choices[i]).appendTo('#choice-block');
                    }
                }
            }

            /**
             * Resets all of the fields to prepare for next question
             */
            function nextQuestion(){
                submt = true;
                $('#explanation').empty();
                $('#question').text(quiz[currentquestion]['question']);
                $('#pager').text('Question ' + Number(currentquestion + 1) + ' of ' + quiz.length);
                if(quiz[currentquestion].hasOwnProperty('image') && quiz[currentquestion]['image'] != ""){
                    if($('#question-image').length == 0){
                        $(document.createElement('img')).addClass('question-image').attr('id', 'question-image').attr('src', quiz[currentquestion]['image']).attr('alt', htmlEncode(quiz[currentquestion]['question'])).insertAfter('#question');
                    } else {
                        $('#question-image').attr('src', quiz[currentquestion]['image']).attr('alt', htmlEncode(quiz[currentquestion]['question']));
                    }
                } else {
                    $('#question-image').remove();
                }
                addChoices(quiz[currentquestion]['choices']);
                setupButtons();
            }

            /**
             * After a selection is submitted, checks if its the right answer
             *
             * @param {choice} number The li zero-based index of the choice picked
             */
            function processQuestion(choice){
                if(quiz[currentquestion]['choices'][choice] == quiz[currentquestion]['correct']){
                    $('.choice').eq(choice).css({'background-color':'#50D943'});
                    $('#explanation').html('<strong>Correct!</strong> ' + htmlEncode(quiz[currentquestion]['explanation']));
                    score++;
                } else {
                    $('.choice').eq(choice).css({'background-color':'#D92623'});
                    $('#explanation').html('<strong>Incorrect.</strong> ' + htmlEncode(quiz[currentquestion]['explanation']));
                }
                currentquestion++;
                $('#submitbutton').html('NEXT QUESTION &raquo;').on('click', function(){
                    if(currentquestion == quiz.length){
                        endQuiz();
                    } else {
                        $(this).text('Check Answer').css({'color':'#222'}).off('click');
                        nextQuestion();
                    }
                })
            }

            /**
             * Sets up the event listeners for each button.
             */
            function setupButtons(){
                $('.choice').on('mouseover', function(){
                    $(this).css({'background-color':'#e1e1e1'});
                });
                $('.choice').on('mouseout', function(){
                    $(this).css({'background-color':'#fff'});
                })
                $('.choice').on('click', function(){
                    picked = $(this).attr('data-index');
                    $('.choice').removeAttr('style').off('mouseout mouseover');
                    $(this).css({'border-color':'#222','font-weight':700,'background-color':'#c1c1c1'});
                    if(submt){
                        submt=false;
                        $('#submitbutton').css({'color':'#000'}).on('click', function(){
                            $('.choice').off('click');
                            $(this).off('click');
                            processQuestion(picked);
                        });
                    }
                })
            }

            /**
             * Quiz ends, display a message.
             */
            function endQuiz(){
                $('#explanation').empty();
                $('#question').empty();
                $('#choice-block').empty();
                $('#submitbutton').remove();
                $('#question').text("You got " + score + " out of " + quiz.length + " correct.");
                $(document.createElement('h2')).css({'text-align':'center', 'font-size':'4em'}).text(Math.round(score/quiz.length * 100) + '%').insertAfter('#question');
            }

            /**
             * Runs the first time and creates all of the elements for the quiz
             */
            function init(){
                //add title
                if(typeof quiztitle !== "undefined" && $.type(quiztitle) === "string"){
                    $(document.createElement('h1')).text(quiztitle).appendTo('#frame');
                } else {
                    $(document.createElement('h1')).text("Quiz").appendTo('#frame');
                }

                //add pager and questions
                if(typeof quiz !== "undefined" && $.type(quiz) === "array"){
                    //add pager
                    $(document.createElement('p')).addClass('pager').attr('id','pager').text('Question 1 of ' + quiz.length).appendTo('#frame');
                    //add first question
                    $(document.createElement('h2')).addClass('question').attr('id', 'question').text(quiz[0]['question']).appendTo('#frame');
                    //add image if present
                    if(quiz[0].hasOwnProperty('image') && quiz[0]['image'] != ""){
                        $(document.createElement('img')).addClass('question-image').attr('id', 'question-image').attr('src', quiz[0]['image']).attr('alt', htmlEncode(quiz[0]['question'])).appendTo('#frame');
                    }
                    $(document.createElement('p')).addClass('explanation').attr('id','explanation').html('&nbsp;').appendTo('#frame');

                    //questions holder
                    $(document.createElement('ul')).attr('id', 'choice-block').appendTo('#frame');

                    //add choices
                    addChoices(quiz[0]['choices']);

                    //add submit button
                    $(document.createElement('div')).addClass('choice-box').attr('id', 'submitbutton').text('Check Answer').css({'font-weight':700,'color':'#222','padding':'30px 0'}).appendTo('#frame');

                    setupButtons();
                }
            }

            init();
        });
    </script>
    <style type="text/css" media="all">
        /*css reset */
        html,body,div,span,h1,h2,h3,h4,h5,h6,p,code,small,strike,strong,sub,sup,b,u,i{border:0;font-size:100%;font:inherit;vertical-align:baseline;margin:0;padding:0;}
        article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block;}
        body{line-height:1; font:normal 0.9em/1em "Helvetica Neue", Helvetica, Arial, sans-serif;}
        ol,ul{list-style:none;}
        strong{font-weight:700;}
        #frame{max-width:620px;width:auto;border:1px solid #ccc;background:#fff;padding:10px;margin:3px;}
        h1{font:normal bold 2em/1.8em "Helvetica Neue", Helvetica, Arial, sans-serif;text-align:left;border-bottom:1px solid #999;padding:0;width:auto}
        h2{font:italic bold 1.3em/1.2em "Helvetica Neue", Helvetica, Arial, sans-serif;padding:0;text-align:center;margin:20px 0;}
        p.pager{margin:5px 0 5px; font:bold 1em/1em "Helvetica Neue", Helvetica, Arial, sans-serif;color:#999;}
        img.question-image{display:block;max-width:250px;margin:10px auto;border:1px solid #ccc;width:100%;height:auto;}
        #choice-block{display:block;list-style:none;margin:0;padding:0;}
        #submitbutton{background:#5a6b8c;}
        #submitbutton:hover{background:#7b8da6;}
        #explanation{margin:0 auto;padding:20px;width:75%;}
        .choice-box{display:block;text-align:center;margin:8px auto;padding:10px 0;border:1px solid #666;cursor:pointer;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
    </style>
<script>
    const readlineSync = require('readline-sync');

    console.log('Welcome to the Quiz');
    let username = readlineSync.question("What's your Name: \n");
    console.log('Hello',username,", Let's Play the Quiz!!");

    console.log('\n');
    console.log('Rules & Instructions: ');
    console.log('1.',username + ', There are 10 Questions on India and all are Compulsory.');
    console.log('2. You will get 2 points on each Right Answer.');
    console.log('3. One Point will be deducted if the Answer is Wrong.');
    console.log('4. In MCQ based questions you have to type the Serial Number / Index Value.');
    console.log('\n');

    var questionsList = [
        {
            question : 'India\'s Largest City by Population: ',
            answer : 'Mumbai',
        },
        {
            question : 'National Song of India: ',
            answer : 'Vande Mataram',
        },
        {
            question : 'National Motto of India: ',
            answer : 'Satyameva Jayate',
        },
        {
            question : 'Golden Temple is situated in: ',
            answer : 'Amritsar',
        },
    ];

    var mcqList = [

        {
            array : ['Mumbai', 'Hyderabad', 'Guragon', 'Bangalore'],
            question : 'Which City is known as "Electronic City of India"? ',
            answer : 'Bangalore'
        },
        {
            array : ['Kerala', 'Madras', 'Bangalore', 'New Delhi'],
            question : 'The Indian Institute of Science is located at ',
            answer : 'Bangalore'
        },
        {
            array : ['Dugong', 'Blue whale', 'River Dolphin', 'Pygmy Killer Whale'],
            question : 'What is the name of India\'s National Aquactic Animal: ',
            answer : 'River Dolphin'
        },
        {
            array : ['New Delhi', 'Hyderabad', 'Amritsar', 'Mumbai'],
            question : 'The Centre for Cellular and Molecular Biology in India is situated at: ',
            answer : 'Hyderabad'
        },
        {
            array : ['Delhi', 'Dehradun', 'Lucknow', 'Gandhinagar'],
            question : 'National Institute of Aeronautical Engineering is located at ',
            answer : 'Delhi'
        },
        {
            array : ['T.N.Kaul', 'J.R.D. Tata', 'Nani Palkhivala', 'Khushwant Singh'],
            question : 'Who wrote the famous book - "We the people"? ',
            answer : 'Nani Palkhivala'
        },
    ];

    let score = 0;
    function quiz(question,answer){
        let userAnswer = readlineSync.question(question);

        if(userAnswer.toLowerCase() == answer.toLowerCase()){
            console.log('You are Right.');
            score = score + 2;
        } else{
            console.log('You are Wrong.');
            console.log('The Correct Answer is:',answer);
            score = score - 1;
        }

        if(score < 0){
            score = 0;
        }
        console.log(chalk.cyan('Score is: ',score));
    }

    function quizMcq(listOfAnswers,question,answer){
        let userAnswer = readlineSync.keyInSelect(listOfAnswers, question);
        console.log('\n');
        if(listOfAnswers[userAnswer] === answer){
            console.log('You are Right.');
            score = score + 2;
        } else{
            console.log('You are Wrong.');
            console.log('The Correct Answer is: ',answer);
            score = score - 1;
        }

        if(score < 0){
            score = 0;
        }
        console.log('Score is: ',score);
    }

    for(var i = 0;i<questionsList.length;i++){
        console.log('\n');
        quiz(questionsList[i].question,questionsList[i].answer);
        console.log('*******************************');
    }

    for(var i = 0;i < mcqList.length; i++){
        console.log('\n');
        quizMcq(mcqList[i].array,mcqList[i].question,mcqList[i].answer);
        console.log('*******************************');
    }

    console.log('\n');
    console.log('Congratulations,',username,'your Total Score is: ',score);

</script>
</head>
<body>
<div id="frame" role="content"></div>

</body>
</html>
<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Awesome Quiz App | CodingNepal</title> -->
    <link rel="stylesheet" href="style.css">
    <!-- FontAweome CDN Link for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<style>
    /* importing google fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body{
        background: #007bff;
    }

    ::selection{
        color: #fff;
        background: #007bff;
    }

    .start_btn,
    .info_box,
    .quiz_box,
    .result_box{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2),
        0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .info_box.activeInfo,
    .quiz_box.activeQuiz,
    .result_box.activeResult{
        opacity: 1;
        z-index: 5;
        pointer-events: auto;
        transform: translate(-50%, -50%) scale(1);
    }

    .start_btn button{
        font-size: 25px;
        font-weight: 500;
        color: #007bff;
        padding: 15px 30px;
        outline: none;
        border: none;
        border-radius: 5px;
        background: #fff;
        cursor: pointer;
    }

    .info_box{
        width: 540px;
        background: #fff;
        border-radius: 5px;
        transform: translate(-50%, -50%) scale(0.9);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .info_box .info-title{
        height: 60px;
        width: 100%;
        border-bottom: 1px solid lightgrey;
        display: flex;
        align-items: center;
        padding: 0 30px;
        border-radius: 5px 5px 0 0;
        font-size: 20px;
        font-weight: 600;
    }

    .info_box .info-list{
        padding: 15px 30px;
    }

    .info_box .info-list .info{
        margin: 5px 0;
        font-size: 17px;
    }

    .info_box .info-list .info span{
        font-weight: 600;
        color: #007bff;
    }
    .info_box .buttons{
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 0 30px;
        border-top: 1px solid lightgrey;
    }

    .info_box .buttons button{
        margin: 0 5px;
        height: 40px;
        width: 100px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        outline: none;
        border-radius: 5px;
        border: 1px solid #007bff;
        transition: all 0.3s ease;
    }

    .quiz_box{
        width: 550px;
        background: #fff;
        border-radius: 5px;
        transform: translate(-50%, -50%) scale(0.9);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .quiz_box header{
        position: relative;
        z-index: 2;
        height: 70px;
        padding: 0 30px;
        background: #fff;
        border-radius: 5px 5px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0px 3px 5px 1px rgba(0,0,0,0.1);
    }

    .quiz_box header .title{
        font-size: 20px;
        font-weight: 600;
    }

    .quiz_box header .timer{
        color: #004085;
        background: #cce5ff;
        border: 1px solid #b8daff;
        height: 45px;
        padding: 0 8px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 145px;
    }

    .quiz_box header .timer .time_left_txt{
        font-weight: 400;
        font-size: 17px;
        user-select: none;
    }

    .quiz_box header .timer .timer_sec{
        font-size: 18px;
        font-weight: 500;
        height: 30px;
        width: 45px;
        color: #fff;
        border-radius: 5px;
        line-height: 30px;
        text-align: center;
        background: #343a40;
        border: 1px solid #343a40;
        user-select: none;
    }

    .quiz_box header .time_line{
        position: absolute;
        bottom: 0px;
        left: 0px;
        height: 3px;
        background: #007bff;
    }

    section{
        padding: 25px 30px 20px 30px;
        background: #fff;
    }

    section .que_text{
        font-size: 25px;
        font-weight: 600;
    }

    section .option_list{
        padding: 20px 0px;
        display: block;
    }

    section .option_list .option{
        background: aliceblue;
        border: 1px solid #84c5fe;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 17px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    section .option_list .option:last-child{
        margin-bottom: 0px;
    }

    section .option_list .option:hover{
        color: #004085;
        background: #cce5ff;
        border: 1px solid #b8daff;
    }

    section .option_list .option.correct{
        color: #155724;
        background: #d4edda;
        border: 1px solid #c3e6cb;
    }

    section .option_list .option.incorrect{
        color: #721c24;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
    }

    section .option_list .option.disabled{
        pointer-events: none;
    }

    section .option_list .option .icon{
        height: 26px;
        width: 26px;
        border: 2px solid transparent;
        border-radius: 50%;
        text-align: center;
        font-size: 13px;
        pointer-events: none;
        transition: all 0.3s ease;
        line-height: 24px;
    }
    .option_list .option .icon.tick{
        color: #23903c;
        border-color: #23903c;
        background: #d4edda;
    }

    .option_list .option .icon.cross{
        color: #a42834;
        background: #f8d7da;
        border-color: #a42834;
    }

    footer{
        height: 60px;
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid lightgrey;
    }

    footer .total_que span{
        display: flex;
        user-select: none;
    }

    footer .total_que span p{
        font-weight: 500;
        padding: 0 5px;
    }

    footer .total_que span p:first-child{
        padding-left: 0px;
    }

    footer button{
        height: 40px;
        padding: 0 13px;
        font-size: 18px;
        font-weight: 400;
        cursor: pointer;
        border: none;
        outline: none;
        color: #fff;
        border-radius: 5px;
        background: #007bff;
        border: 1px solid #007bff;
        line-height: 10px;
        opacity: 0;
        pointer-events: none;
        transform: scale(0.95);
        transition: all 0.3s ease;
    }

    footer button:hover{
        background: #0263ca;
    }

    footer button.show{
        opacity: 1;
        pointer-events: auto;
        transform: scale(1);
    }

    .result_box{
        background: #fff;
        border-radius: 5px;
        display: flex;
        padding: 25px 30px;
        width: 450px;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        transform: translate(-50%, -50%) scale(0.9);
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .result_box .icon{
        font-size: 100px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .result_box .complete_text{
        font-size: 20px;
        font-weight: 500;
    }

    .result_box .score_text span{
        display: flex;
        margin: 10px 0;
        font-size: 18px;
        font-weight: 500;
    }

    .result_box .score_text span p{
        padding: 0 4px;
        font-weight: 600;
    }

    .result_box .buttons{
        display: flex;
        margin: 20px 0;
    }

    .result_box .buttons button{
        margin: 0 10px;
        height: 45px;
        padding: 0 20px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        outline: none;
        border-radius: 5px;
        border: 1px solid #007bff;
        transition: all 0.3s ease;
    }

    .buttons button.restart{
        color: #fff;
        background: #007bff;
    }

    .buttons button.restart:hover{
        background: #0263ca;
    }

    .buttons button.quit{
        color: #007bff;
        background: #fff;
    }

    .buttons button.quit:hover{
        color: #fff;
        background: #007bff;
    }
</style>
<body>
<!-- start Quiz button -->

<!-- Info Box -->
<div class="info_box">
    <div class="info-title"><span>Some Rules of this Quiz</span></div>
    <div class="info-list">
        <div class="info">1. You will have only <span>15 seconds</span> per each question.</div>
        <div class="info">2. Once you select your answer, it can't be undone.</div>
        <div class="info">3. You can't select any option once time goes off.</div>
        <div class="info">4. You can't exit from the Quiz while you're playing.</div>
        <div class="info">5. You'll get points on the basis of your correct answers.</div>
    </div>
    <div class="buttons">
        <button class="quit">Exit Quiz</button>
        <button class="restart">Continue</button>
    </div>
</div>

<!-- Quiz Box -->
<div class="quiz_box">
    <header>
        <div class="title">Awesome Quiz Application</div>
        <div class="timer">
            <div class="time_left_txt">Time Left</div>
            <div class="timer_sec">15</div>
        </div>
        <div class="time_line"></div>
    </header>
    <section>
        <div class="que_text">
            <!-- Here I've inserted question from JavaScript -->
        </div>
        <div class="option_list">
            <!-- Here I've inserted options from JavaScript -->
        </div>
    </section>

    <!-- footer of Quiz Box -->
    <footer>
        <div class="total_que">
            <!-- Here I've inserted Question Count Number from JavaScript -->
        </div>
        <button class="next_btn">Next Que</button>
    </footer>
</div>

<!-- Result Box -->
<div class="result_box">
    <div class="icon">
        <i class="fas fa-crown"></i>
    </div>
    <div class="complete_text">You've completed the Quiz!</div>
    <div class="score_text">
        <!-- Here I've inserted Score Result from JavaScript -->
    </div>
    <div class="buttons">
        <button class="restart">Replay Quiz</button>
        <button class="quit">Quit Quiz</button>
    </div>
</div>

<!-- Inside this JavaScript file I've inserted Questions and Options only -->
<!-- <script src="js/questions.js"></script> -->

<!-- Inside this JavaScript file I've coded all Quiz Codes -->
<!-- <script src="js/script.js"></script> -->

</body>
</html>
</html>
@endsection