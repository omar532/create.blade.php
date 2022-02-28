@extends('layouts.test')

@section('content')
    <html>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://jchamill.github.io/jquery-quiz/jquery.quiz-min.js"></script>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Quiz Science</title>
    </head>
    <body>
    <style>
        body {
            background-color: #413D3D;
        }
        .back{
            background-image:url('https://images.ladepeche.fr/api/v1/images/view/5c2f81003e45460d250fc8b4/large/image.jpg');
            font-family: 'Open Sans', sans-serif;
        }

        .grid {
            width: 600px;
            height: 500px;
            border-radius:500px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, .8);
            padding: 10px 50px 50px 50px;
            border: 2px solid #cbcbcb;

        }

        .grid h1 {
            font-family: "sans-serif";
            background-color: transparent;
            border-radius:500px;
            font-size: 30px;
            text-align: center;
            color: #01BBFF;
            padding: 2px 0px;

        }

        #score {
            color: #01BBFF;
            text-align: center;
            font-size: 30px;
        }

        .grid #question {
            text-align: center;
            font-family: "monospace";
            font-size: 30px;
            color: #01BBFF;
        }

        .buttons {
            margin-top: 30px;
        }

        #btn0, #btn1, #btn2, #btn3 {
            background-color: #01BBFF;
            width: 130px;
            border-radius:500px;
            font-size: 20px;
            color: #fff;
            border: 1px solid #1D3C6A;
            margin: 10px 40px 10px 0px;
            padding: 10px 10px;
        }

        #btn0:hover, #btn1:hover, #btn2:hover, #btn3:hover {
            cursor: pointer;
            background-color: #01BBFF;
        }

        #btn0:focus, #btn1:focus, #btn2:focus, #btn3:focus {
            outline: 0;
        }

        #progress {
            color: #2b2b2b;
            font-size: 12px;
        }
        canvas{
            position:absolute;
            left:0;
            top:0;
            z-index:0;
            border:0px solid #000;
        }
    </style>


    <div class="back">
        <div class="grid">
            <div id="quiz">
                <h1>Quiz Animal</h1>
                <br>
                <CENTER><div id="image"></div></CENTER>
                <p id="categorie"></p>
                <p id="question"></p>
                <div class="btn-group">
                    <button id="btn0"><span id="choice0"></span></button>
                    <button id="btn1"><span id="choice1"></span></button>
                    <button id="btn2"><span id="choice2"></span></button>
                </div>
                <audio src="{{asset('songs/song.mp3')}}"
                       controls autoplay hidden></audio>
                <br><br><br>
                <footer>
                   <center> <p id="progress">Question x of y</p></center>
                </footer>
            </div>
        </div>
        <canvas id="canvas"></canvas>
        <audio src="{{asset('songs/effects.mp3')}}" id="song_result"  hidden></audio>

    </div>
    <script>
        // code by webdevtrick (https://webdevtrick.com)
        function Quiz(questions) {
            this.score = 0;
            this.questions = questions;
            this.questionIndex = 0;

        }

        Quiz.prototype.getQuestionIndex = function() {
            return this.questions[this.questionIndex];
        }

        Quiz.prototype.guess = function(answer) {
            if(this.getQuestionIndex().isCorrectAnswer(answer)) {
                this.score++;
            }

            this.questionIndex++;
        }

        Quiz.prototype.isEnded = function() {
            return this.questionIndex === this.questions.length;
        }


        function Question(text, choices, answer) {
            this.text = text;
            this.choices = choices;
            this.answer = answer;
        }

        Question.prototype.isCorrectAnswer = function(choice) {
            return this.answer === choice;
        }


        function populate() {
            if(quiz.isEnded()) {
                showScores();
            }
            else {
                // show question
                var element = document.getElementById("question");
                element.innerHTML = quiz.getQuestionIndex().text;

                // show options
                var choices = quiz.getQuestionIndex().choices;
                for(var i = 0; i < choices.length; i++) {
                    var element = document.getElementById("choice" + i);
                    element.innerHTML = choices[i];
                    guess("btn" + i, choices[i]);
                }

                showProgress();
            }
        };

        function guess(id, guess) {
            var button = document.getElementById(id);
            button.onclick = function() {
                quiz.guess(guess);
                populate();
            }
        };


        function showProgress() {
            var currentQuestionNumber = quiz.questionIndex + 1;
            var element = document.getElementById("progress");
            element.innerHTML = "Question " + currentQuestionNumber + " of " + quiz.questions.length;
            if(currentQuestionNumber==1){
                var img = document.createElement("img");
                img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQVGsDSLSbJakUqjLH4lGTAza0S3ZCHpiYMCQ&usqp=CAU";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }else if(currentQuestionNumber==2){
                var img = document.createElement("img");
                img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQOAat2U6drzt-e791UDF8YZz0TL8hRG2YrjQ&usqp=CAU";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }else if(currentQuestionNumber==3){
                var img = document.createElement("img");
                img.src = "data:image/jpeg;base64,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";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }
            else if(currentQuestionNumber==4){
                var img = document.createElement("img");
                img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQht56gGL_Y62LJ9BJIqraOB8j17SzCdRKRUA&usqp=CAU";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }
            else{
                var img = document.createElement("img");
                img.src = "data:image/jpeg;base64,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";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }
        };


        function showScores() {
            var gameOverHTML = "<h1>Result</h1>";
            gameOverHTML += "<h2 id='score'> Your scores: " + quiz.score + "</h2>";
            var element = document.getElementById("quiz");
            element.innerHTML = gameOverHTML;
            if(quiz.score>1)
                return confettiEffect();
        };

        // create questions here
        var questions = [
            new Question("what's this ?", ["Lion", "Tiger","Dog"],"Lion"),
            new Question("what's this ?", ["Cat", "Panda","Dog"],"Dog"),
            new Question("what's this ?", ["Delfin", "Shark","Tuna"],"Delfin"),
            new Question("what's this ?", ["Cat", "Sheep","Dog"],"Sheep"),
            new Question("what's this ?", ["Cat", "Danky","Mouse"],"Cat"),
        ];
        // create quiz
        var quiz = new Quiz(questions,image);
        // display quiz
        populate();
        function confettiEffect (){
            //grabing area to create the effect
            document.getElementById('song_result').play();

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

                function voice () {
                    $("#jpId").jPlayer(
                        {ready: function () {
                                $(this).jPlayer("setMedia", {
                                    mp3: "https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" // Url of the mp3 file
                                }).jPlayer("play");
                            },
                            supplied: "mp3"
                        }
                    );
                }
            }
        }
        var countDownDate = 0;

        // Update the count down every 1 second
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate + now;
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("demo").innerHTML =seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

    </body>
    </html>
@endsection