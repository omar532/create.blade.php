@extends('layouts.test')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://jchamill.github.io/jquery-quiz/jquery.quiz-min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .back {
        url('http://www.planwallpaper.com/static/images/website-background-pattern.jpg');
            margin: 0 auto;
            font-family: 'Lato', sans-serif;
            color: #b3b3b3;
            background-color: #31a2ac;
            text-align: center;
            margin-top: 0;
        }

        .main {
            background-color: white;
            margin: 0 auto;
            width: 60%;
            margin-top: 30px;
            padding: 30px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        /*
                span {
                    float: left;
                }

                span {
                    float: left;
                }

                p {
                    padding: 10px 10px 0;
                }

                .form-area, ul {
                    margin: 20px auto;
                    max-width: 550px;
                }
        */
        li1 {
            list-style-type: none;
            text-align: left;
            background-color: transparent;
            margin: 10px 5px;
            padding: 5px 10px;
            border: 1px solid lightgray;
            font-weight: normal;
        }

        li1:hover {
            background: #ECEEF0;
        }

        /*Change effect of question when the questions is selected*/
        .selected, .selected:hover {
            background: #FFDEAD;
        }

        /*change correct answer background*/
        .correct, .correct:hover {
            background: #9ACD32;
            color: white;
        }

        /*change wrong answer background*/
        .wrong, .wrong:hover {
            background: #db3c3c;
            color: white;
        }

        /*========================================================
                Submit Button
        ========================================================*/
        .main button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            width: 20%;
            border: none;
            padding: 15px;
            color: #FFFFFF;
        }

        .submit:hover, .submit:active, .submit:focus {
            background: #43A047;
        }

        .submit {
            background: #4CAF50;
            min-width: 120px;
        }

        /*next question button*/
        .next {
            background: #fa994a;
            min-width: 120px;
        }

        .next:hover, .next:active, .next:focus {
            background: #e38a42;
        }

        .restart {
            background-color:RED;
        }

        /*========================================================
                Results
        ========================================================*/
        .circle{
            position: relative;
            margin: 0 auto;
            width: 200px;
            height: 200px;
            background: #bdc3c7;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
            overflow: hidden;
        }

        .fill{
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 80%;
            background: #31a2ac;
        }

        h3 {
            position: absolute;
            width: 100%;
            top: 60px;
            text-align: center;
            font-family: Arial, sans-serif;
            color: #fff;
            font-size: 40pt;
            line-height: 0;
            font-weight: normal;
        }

        .circle p {
            margin: 400px;
        }

        /*========================================================
                Confeeti Effect
        ========================================================*/
        canvas{
            position:absolute;
            left:0;
            top:0;
            z-index:0;
            border:0px solid #000;
        }

    </style>
    <div class="back">
    <div class="main">
        <!-- Number of Question  -->
        <div class="wrapper" id="pages">
            <span id="quizNumber"></span><span></span>
        </div>

        <!-- Quiz Question -->
        <div class="quiz-questions" id="display-area">
            <div id="image"><img id="qImg" src=""></div>
            <p id="question"></p>
            <ul id="answer">

            </ul>
<form class="col s8 offset-s2">
           <input type="hidden" id="rate" min="1" max="100" value="10" />
           <input type="hidden" id="pitch" min="0" max="2" value="1" />
           <input type="hidden" id="message" class="materialize-textarea" value="What's the color of apple"></input>
           <i href="#" id="speak" class="nav-icon fas fa-bullhorn"></i>
  </form>
            <div id="quiz-results">
                <button type="button" name="button" class="submit" id="submit">Submit</button>
            </div>

        </div>
</div>

<div id="modal1" class="modal">
  <div class="action-bar">
    <a href="#" class="waves-effect waves-green btn-flat modal-action modal-close">Close</a>
  </div>
</div>

    </div>
    <center>
    <a class="btn btn-success" href="{{route('testQuizAppel')}}">Home</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="btn btn-success" href="{{route('NextQuiz2')}}">Next</a>
    </center>
    <canvas id="canvas"></canvas>
    <script >
        // Creating questionss and answers
        //*****************************************************************************
        var question1 = {
            qImg: "data:image/jpeg;base64,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",
            question: "What's the color of apple",
            answers: ["Yellow", "Red", "Green "],
            correct: 1
            };

        // create an array of objects
        var questions = [question1];
        // Initialize variables
        //------------------------------------------------------------------
        $('#qImg').attr('src','');
        var tags;
        var tagsClass = '';
        var liTagsid = [];
        var correctAns = 0;
        var quizPage = 1;
        var currentIndex = 0;
        var currentQuestion = questions[currentIndex];
        var prevousQuestion;
        var previousIndex = 0;
        var ulTag = document.getElementsByTagName('ul')[0];
        var button = document.getElementById('submit');
        var questionTitle = document.getElementById('question');
        var questionImage = document.getElementById('qImg');
        if (question1.qImg !== "") {
            $('#qImg').attr('src',question1.qImg).show();
        } else {
            $('#qImg').hide();
        }
        //save class name so it can be reused easily
        //if I want to change it, I have to change it one place
        var classHighlight = 'selected';
        // Display Answers and hightlight selected item
        //------------------------------------------------------------------
        function showQuestions (){
            if (currentIndex != 0) {
                // create again submit button only for next pages
                ulTag.innerHTML ='';
                button.innerHTML = 'Submit';
                button.className = 'submit';
                button.id = 'submit';
                //update the number of questions displayed
                document.getElementById('quizNumber').innerHTML = quizPage;
            }
            //Display Results in the final page
            if (currentIndex ==  (questions.length)) {
                ulTag.innerHTML = '';
                document.getElementById('question').innerHTML = '';
                showResults();
                return
            }
            questionTitle.innerHTML = currentQuestion.question;
            console.log(currentQuestion.question);
            // create a for loop to generate the answers and display them in the page
            for (var i = 0; i < currentQuestion.answers.length; i++) {
                // creating answers
                var newAns = document.createElement('li1');
                newAns.id = 'ans'+ (i+1);
                newAns.className = "notSelected";
                var textAns = document.createTextNode(currentQuestion.answers[i]);
                newAns.appendChild(textAns);
                var addNewAnsHere = document.getElementById('answer');
                addNewAnsHere.appendChild(newAns);
                console.log(currentQuestion.answers[i]);
            }

            //.click() will return the result of $('.notSelected')
            var $liTags = $('.notSelected').click(function(list) {
                list.preventDefault();
                //run removeClass on every element
                //if the elements are not static, you might want to rerun $('.notSelected')
                //instead of the saved $litTags
                $liTags.removeClass(classHighlight);
                //add the class to the currently clicked element (this)
                $(this).addClass(classHighlight);

                //get id name of clicked answer
                for (var i = 0; i < currentQuestion.answers.length ; i++) {
                    // console.log(liTagsid[i]);
                    if($liTags[i].className == "notSelected selected"){
                        //store information to check answer
                        tags = $liTags[i].id;
                        // tagsClass = $LiTags.className;
                        console.log(tags);
                        tagsClassName = $liTags[i];
                    }
                }
            });
            //check answer once it has been submitted
            button.onclick = function (){ checkAnswer()};
        }
        //self calling function
        showQuestions();
        // Show Correct Answer
        //------------------------------------------------------------------
        function checkAnswer (){
            // get selected list
            var selectedItem = document.getElementById(tags);

            // check that an answer has been selected
            if (selectedItem == undefined) {
                alert("Please selected an answer!")
                return
            } else {
                // get user answer if form of text
                var userAns = selectedItem.innerHTML;
            }
            // change the background of the answer according to the Results
            if (userAns == currentQuestion.answers[currentQuestion.correct]) {
                console.log("Correct! The answer is: "+ userAns);
                // change color of selected item by changing className
                selectedItem.className = 'correct';
                // count the number of correct answers
                correctAns++;
                console.log(correctAns);
            } else {
                console.log("Wrong! The corrent answer is: "+  currentQuestion.answers[currentQuestion.correct]);
                //change the background of the wrong answer
                selectedItem.className = 'wrong';
                //hightlight the right answer if the user got it wrong
                //change the class name of the correct answer
                ulTag.getElementsByTagName('li')[currentQuestion.correct].className = 'correct';
                console.log(currentQuestion.answers[currentQuestion.correct]);
            }
            // Create a next Question button once the answer has been submitted
            button.innerHTML = 'Show result';
            button.className = 'next';
            button.id = 'next';
            prevousQuestion = currentQuestion;
            quizPage++;
            currentIndex++;
            currentQuestion = questions[currentIndex];
            // Start with the next question once the "Next" button has been clicked
            button.onclick = function (){showQuestions()};
            return
        }
        // Final score
        //------------------------------------------------------------------
        function showResults () {
            //deleting page number
            document.getElementById('pages').innerHTML='';
            // Change Title
            questionTitle.innerHTML = '<h1></h1>';
            // Get the area that will be used to display the user's score
            var newInfo = document.getElementById('quiz-results');
            //Change the id and className of the area for the circle
            newInfo.innerHTML = '';
            newInfo.id = 'circle';
            newInfo.className = 'circle';
            //Create a Div for the fill element
            var newDiv = document.createElement('div');
            newDiv.className = 'fill';
            var addHere = document.getElementById('circle');
            addHere.appendChild(newDiv);
            // add the score to the circle
            var newScore = document.createElement('h3');
            newScore.className = 'score';
            var textScore = document.createTextNode(Math.floor((correctAns/questions.length)*100) + '%');
            newScore.appendChild(textScore);
            addHere.appendChild(newScore);
            //use jquary to grab the text of the score
            var score = $(".score").text();
            //fill the circle in base of the score
            $(".fill").css("height",score);
            if (correctAns >= 1) {
                var newCongrats = document.createElement('p');
                var textCongrats = document.createTextNode('Congratulations! You did a Good Job!')
                newCongrats.appendChild(textCongrats);
                document.getElementById('display-area').appendChild(newCongrats);
                confettiEffect();
            }
        }

        // Confetti Effect by Gtibo "Confetti Party"
        //------------------------------------------------------------------
        function confettiEffect (){
            //grabing area to create the effect
            canvas = document.getElementById("canvas");
            context = canvas.getContext("2d");
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;

            // creating the tabel
            particle = [];
            particleCount = 0,
                gravity = 0.3,
                colors = [
                    '#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5',
                    '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4CAF50',
                    '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800',
                    '#FF5722', '#795548'
                ];

            for( var i = 0; i < 300; i++){

                particle.push({
                    x : width/2,
                    y : height/2,
                    boxW : randomRange(5,20),
                    boxH : randomRange(5,20),
                    size : randomRange(2,8),

                    spikeran:randomRange(3,5),

                    velX :randomRange(-8,8),
                    velY :randomRange(-50,-10),

                    angle :convertToRadians(randomRange(0,360)),
                    color:colors[Math.floor(Math.random() * colors.length)],
                    anglespin:randomRange(-0.2,0.2),

                    draw : function(){
                        context.save();
                        context.translate(this.x,this.y);
                        context.rotate(this.angle);
                        context.fillStyle=this.color;
                        context.beginPath();

                        context.fillRect(this.boxW/2*-1,this.boxH/2*-1,this.boxW,this.boxH);
                        context.fill();
                        context.closePath();
                        context.restore();
                        this.angle += this.anglespin;
                        this.velY*= 0.999;
                        this.velY += 0.3;

                        this.x += this.velX;
                        this.y += this.velY;

                        if(this.y < 0){
                            this.velY *= -0.2;
                            this.velX *= 0.9;
                        };

                        if(this.y > height){
                            this.anglespin = 0;
                            this.y = height;
                            this.velY *= -0.2;
                            this.velX *= 0.9;
                        };

                        if(this.x > width ||this.x< 0){
                            this.velX *= -0.5;
                        };
                    },
                });
            }

            function drawScreen(){
                context.globalAlpha = 1;
                for( var i = 0; i < particle.length; i++){
                    particle[i].draw();
                }
            }

            function loadImage(url){
                var img = document.createElement("img");
                img.src=url;
                return img;
            }

            function update(){
                context.clearRect(0,0,width,height);
                drawScreen();
                requestAnimationFrame(update);
            }

            update();

            function randomRange(min, max){
                return min + Math.random() * (max - min );
            }

            function randomInt(min, max){
                return Math.floor(min + Math.random()* (max - min + 1));
            }

            function convertToRadians(degree) {
                return degree*(Math.PI/180);
            }

            function drawStar(cx, cy, spikes, outerRadius, innerRadius,color) {
                var rot = Math.PI / 2 * 3;
                var x = cx;
                var y = cy;
                var step = Math.PI / spikes;

                context.strokeSyle = "#000";
                context.beginPath();
                context.moveTo(cx, cy - outerRadius)
                for (i = 0; i < spikes; i++) {
                    x = cx + Math.cos(rot) * outerRadius;
                    y = cy + Math.sin(rot) * outerRadius;
                    context.lineTo(x, y)
                    rot += step

                    x = cx + Math.cos(rot) * innerRadius;
                    y = cy + Math.sin(rot) * innerRadius;
                    context.lineTo(x, y)
                    rot += step
                }

                context.lineTo(cx, cy - outerRadius)
                context.closePath();
                context.fillStyle = color;
                context.fill();

            }
        }

        $(function(){
            if ('speechSynthesis' in window) {
                speechSynthesis.onvoiceschanged = function() {
                    var $voicelist = $('#voices');

                    if($voicelist.find('option').length == 0) {
                        speechSynthesis.getVoices().forEach(function(voice, index) {
                            var $option = $('<option>')
                                .val(index)
                                .html(voice.name + (voice.default ? ' (default)' :''));

                            $voicelist.append($option);
                        });

                        $voicelist.material_select();
                    }
                }

                $('#speak').click(function(){
                    var text = $('#message').val();
                    var msg = new SpeechSynthesisUtterance();
                    var voices = window.speechSynthesis.getVoices();
                    msg.voice = voices[$('#voices').val()];
                    msg.rate = $('#rate').val() / 10;
                    msg.pitch = $('#pitch').val();
                    msg.text = text;

                    msg.onend = function(e) {
                        console.log('Finished in ' + event.elapsedTime + ' seconds.');
                    };
                    msg.lang = 'en-US';
                    speechSynthesis.speak(msg);
                })
            } else {
                $('#modal1').openModal();
            }
        });

    </script>
@endsection