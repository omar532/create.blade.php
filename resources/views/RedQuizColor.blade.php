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
           <input type="hidden" id="message" class="materialize-textarea" value="What's the color"></input>
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
        <a class="btn btn-success" href="{{route('QuizSyllabe')}}">Next</a>
    </center>
    <canvas id="canvas"></canvas>
    <script >
        // Creating questionss and answers
        //*****************************************************************************
        var question1 = {
            qImg: "data:image/png;base64,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",
            question: "What's the color",
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