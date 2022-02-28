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
            background-image:url('https://media4.giphy.com/media/1iW2g0lzwdRqNu3m/source.gif');

            font-family: 'Open Sans', sans-serif;
        }

        .grid {
            width: 600px;
            height: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 10px 50px 50px 50px;
            border: 2px solid #cbcbcb;

        }

        .grid h1 {
            font-family: "sans-serif";
            background-color: #01BBFF;
            font-size: 30px;
            text-align: center;
            color: #ffffff;
            padding: 2px 0px;

        }

        #score {
            color: #01BBFF;
            text-align: center;
            font-size: 30px;
        }

        .grid #question {
            font-family: "monospace";
            font-size: 30px;
            color: #01BBFF;
        }

        .buttons {
            margin-top: 30px;
        }

        #btn0, #btn1, #btn2, #btn3 {
            background-color: #01BBFF;
            width: 150px;
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
            <h1>Quiz Science</h1>
            <hr style="margin-bottom: 20px">
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
            <hr style="margin-top: 50px">
            <footer>
                <p id="progress">Question x of y</p>
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
                img.src = "";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }else if(currentQuestionNumber==2){
                var img = document.createElement("img");
                img.src = "data:image/jpeg;base64,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";
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
                img.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQMAAADCCAMAAAB6zFdcAAABX1BMVEX///9kOgiKUQrt7e2/oX34+Pj8+fL+/vxiOgBfNAD09PRgOAAAAAB2WDnt7eXx8OuFTQCrhVvgAABaJwDIvrPy8+2HVQj8+fP7+++3l32+n3jQuJ36///s6uatlnllOQn1x8jvjZFZLgC9sZz19epQIgCCTQ7///jiABR1PADlAADh28zcAACqlX32wMJGRkbufoXkNTqkjm9dYGDUybyCRADu6NvuiY/rcXXxtLUgICCzmnFSGwCYg2iomHdsTyeJa0eOdFlqRh5XNAB3UCyIWiTy6NXazraqhVSedD6XaDSwi2R8RwDe0LrOvavFpYWXaD6SXiXnIDHiDCLz5ebso52kjXekjWZRKABEGACPaS6Tk5OsrKyBgYHsYmv619Pnk5nnTU+EPQDHycnlVlfsZmnwqK/9y9TkPEVvb2+7xMMcHBwAEhjlbHfvubbykIukNjflPTTAmpRLDACxoJDZaDaZAAAMS0lEQVR4nO2djV/aSBrHRzGJoGviYAxlgwUahQZQqaLYl1trt9uqrW4Bu962XcBVltu7tre3/f8/98yEl4BJIMpLQ+dHm0kmIeT55pnJM5NJRIiJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiYmJiekbkSDeUoowbhNuq4C4cFvJHofA3ZqA5yEIt/cCIi8zEISBIIgExm3IbSRovKLwPKcpII3jQwoVzZEhB+ZgCVZoPE9neYV8g2zGa4qmKQG6A2XcdtxGAs+LYFgkpIhgmQ9MhJTkiEZOhOTwxgqeroi0ZiHhxUCIh2QCGCiEAaQROKfEMDizEbANjI9ABknATFgpiiHCQIZtIhRHiOZMiB9AIvONs84vUM/gm8YbfkB9RQ4pBgOygjKQJ5SBaMVA6WDANxkEJoIBOeu+EGXg62QgmxiEGgyo8SY/0PjJZQA5ciunzYBnDJgfMAaMAWPAGDAG3w6D0E3jA8XrDAShIyr02cXKtM1EcxrtxlasbFDxNAMUum6xRQ6BQ8pLgO9uL5B2Y4j3dD8SIsVZ6cUg1GLQajP5Ohh42g8EQUmEEk0J8J9XEjwkCiSQKok+xHu6d10QUOKJf252dg7kf7JClclkVkz6R+YH2ICqmXbIn0EJLzNAiN+PEwQAwb+fIeYTAJm2YH7fD4AoJvOkQWVuajb4FNxp3HbcUOTIdw78U4ZmD1aslFl58Gyqh+I/asizEFBKmgYtE02HZ6x0Gn7T2MBGZAfS85/GbcuNpAKCF68kasP09Jr00opAODxzKE33liSlkBddARDk2kYcEXuvM5g5blLqAeHVa8SN2yLXEtBJrnWKl9fA6y0doS8CBELuxbgtuoFMXjAtLZ5aucHM6VE/JaEB4fW4LXKtDgSHgMCKwcu+EZC9eAsCXBFMBWF6OTxjWRmE3SBYk6SfkJcCBW3ZZJ5kiQD0q7TmAsJ07khRPcTg0FwSXlpeE2ZmzBv1pVfHHkJw+sp05G9svODYTUloeML347asb5kqAwhvwlZXxTAEiO4ZTOd2xm1bn0r8bK4MXlq6Qfi0rwCxW9LiuI3rUyfmyuDIuiDcpCSAlnOvPVEtCmYnX7NB0HeA2O0IR564PL7uvCZY6XSm/wCxS/dT6rgN7CkBLZoqxEPrGNldgNjpCCvjtrAPhUwI3oStQ4OwdHMGy19/WRBSphbz8QxpKHQJGDy/MYLp5QsPXB63L6SGcocz1wmATg9z0s11kRq3hb31+gHtKDxeXDz+3kYvF2+kB3fuwI7vfP0MVDFANYRdc8aePdCfFPFRcaRf2UY33HOgueevXpGhHSljwBgQMQaMAdHXxMC5Xp8IBoIiO6nXYIAJYCD0fAxLnHg/IE9hRSJiZCEiiuJChCxEjClYD9k9IUwCA+PhKqUxaSbmHN5xXMgEMOBlRSTPGMEHUkUWeR8ZJCXKdELWyYpjlTABDEKGnSYGAU1sMtA4wkdxHCY2UQxkg0HIzCDwjTAA59cIAy0Q8mnAQIQJL2u0LGi+EAAZFgMOWsccnViuHi0DuZMB8YNRMNhNFpLRWBEmlqtHWxZkoz6gBYI3CobGG3UiP9Cy0NlPvomTejSGsb5uufGIrwutOpFONOIHrRx5YAy40jUGGBgk8ZgZKMBAkMn4eVk2Hk6GoCCQII8fJ2Ce5vFOO+iTgYBKseJZZ17DD8bOQNBSoJ22IjupLiUce8OcGRgnXhAEdT2N9RrMqaqA4H8CdfkB7XWjPXLN746Mwc7B6urf+5kHDb19+8v5aqf++TThdN/TgYFKCAh0qqp7ehLXyLzaWmViIKgkS6Vqfn00DAT0+lVuTXpuvjX4q7TWpYujHYcGdBcD7t27d+99Hza2/oT5WCwGZpcg2atdgeP/FlsXEB/LJgv5smpmAI7x6bJQ3yxXdmOtAjMCBsTr7uUkMmqifW/kdPH6LaFlafknZHvns4tBYL6pD6iEMa4itZzG6XwWJ5NJnN5E5WQ6nUzqOKaa/UCp6jiNAZOOC03cI2GATi+mG+OHmvfFrIeOkWGjrhnM/14C8y6BgZ7UGwz0XeACKIACrqgmP7iE1UAMtklmR8hAFe6QW4XSr+aBI3YDZsiwUeviYMXg3e9bxBFKOmGASoRB7DINC/m93yAvX64RIGKLQRQqiySuxq50wqDpc6OoDx5RBMszp20G9gNmcimbGsGCwUPIhWSrzQDn0R44+p4K88lCuVzKkxpyt+UH4Ab6Jthewcn06BgI6MUFLevHJjdwGDAjTdtECRYMNhDymRhAWcAfCQO8h6K0SFCnx7E2gywsluCywCVHykChwyqlQ1NBcBw6ZjdOzokBnN1LldQHxA/ImW8x0OFjYlAkDMD00TJQ6Ugq6bl5yITj0DHpqO/6wMSAXheaZQHiA8hKVkul0h/r6+uldn1wCZt8Bttr+kjrg1+oGxybEBw7jyPNRdwygLOaTEcFYqrBYLNcqhMUgWgR/KDcZlADNPrHPXCMUfoBepOTpJx5CFV42XkwxH3r66MDA1SF0wsmJgmDdVyEhU1SGEhBgEuFOUbKkgtDmlwW8Ajrg5XMnZWVE9NIidM7DoKtM9aDIZwYQHRESj8EP3mo7nSoBzbVik6jAFzlID7AOLoLk3VUKpDstK6nR8gAuRveYL91d6y8sbHxL2AAyQekRqvJ5G/RarW+CyHzFaRnJA+sLlbA0Eq9Wo+ekYmKuEo2WazuXVbr+dZvDp0B2X3fo0c4+4NxaDORRmKAM9pMgtFYUskH6kTOaEg1Wkm0JaUqHDI3mSaDAYlCVNJuJk0TaBnShLaNjYYoWUQ0WzCiUHojY4Rt55EwuJUYA8aAiDEYPwOhs6X8TTFo9mh2dOx9Ywyaurqq1cvtRS8y6GNw6DUG8J0EipaMSLWQ3cXldieiFxn0oS4GNGRDlXQZZiC0owxofzetGTzIgNPIGJoA5+QMbQZbW1sP/1zPRkv1fAHXS5VisUL8IF3+I1vM1/dUDzIQZDqWiEwWZPvN2gz+Pf9h/j97eK+ML7O4+hnnP+p72b92cRTrV0l85kEGyoIsijL5gMQF2/cttRk8fIi25mvAIF2p4NIVrl6mr+pQFjZxRf3kQQaCQgaSRYzPAhlXZnfD1IIBjlVwOY/PanBRgLLwWf+oxvCZ5+oDbkEEBvCRF7TG+EKbfbQZzM+jjfltvVhIx2oY1/RiEZcLhRguZ3WM0xXP+QGYL4L1GikQhrQF6y3bDN6/R+/fBT5tfopFuUpMLOfzUfXsLBorBSqfa5Wyt/xAQKnt7e3GHfPtlqwfDLOMkewqDy8x+Pn+/aPwo0ePVsJr91tatDTNOU7s0vgYiBF3L5BTU/eNxyzDYfPjdBea1cYDYzC8ZzA5+EWBc0c3sXS4eGr0EXc8JGfZKT4oBl+eGW868w9c9C1qz+JLrhigQMBqnEAgMMyy8CVo9fa7QWhqirB1yUCI+IyWT4J2Y6qq0XXp8w2VQZy+6O3u4GW8QS647YoB2EUTML4E7Z38R45SaOQOicG9eK/34N1ON2Lw/l20XCus70br2ehubegMtoNDRXB31eUz3wFynBsf/vv5sv7xr2w9W9wrkOO3NNXdfSbgZcNgZ7gMpvwurzvU3A/v/3e5+fmsWtncPLvMN8Bc15JrWd93Rt/5extyCwRP3CEgLksS2hdIxgWSqU1RQPHgebB/ncfP/z6x/tF7Q3WEx64few9c93uLLERCyn2Xp+9Z0OZoEj/MDcd8Iv++WwS03HYjsHQDwfXp8x9Y/iCU1tTju8MBAAruuH8lDNcVDHQvtxXyz7o7mnu2P/pl9e4wKIB7PXYZJBoKLC2dnJy06rGTJetORagnth+7OaD4vu1Pqiiz6o5nn5pdtamCeumF/3EwHj+Hf1CV/X1gV6WQgbrnfgjvrkV45piveTRzwX37h9tgxVI8blAYVIQIPjAXP9i+6YtllcxcMO6fg8/57L2E/XYCSj2N96Vg8MC+IBi70jL+YHxuYPL74+dTXxyfm3BSQkXy0pPvQG+3nXcCjCNL9/rQSUpxPiHQNoFC+Pa7welpZvtWbXLBZv76kQ+w6S8M/pVennhTGhMTExMTExMTExMTExMTExMTExMTExMTExMTExMTExMTExPTRKj955/s/zRU99+J6rHa5kdMC/0cldPBDuhvV3Xv9tYMEgljYv8jzvZ1fsF2P4mGBsjg/w/RapvU3KtxAAAAAElFTkSuQmCC";
                var src = document.getElementById("image");
                $("#image").empty();
                src.appendChild(img);
            }
            else{
                var img = document.createElement("img");
                img.src = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSU4-7XH6-GydLEXlQAJpkOS05eu1Oy_k1rA&usqp=CAU";
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
            new Question("Où se trouve le Big Ben ?", ["Dans l'univers", "À Londres", "En France"],"À Londres"),
            new Question("Où se trouve le mur de Berlin ?", ["En France", "À Londres","En Allemagne"],"En Allemagne"),
            new Question("Dans quel pays le Nutella a-t-il été créé ?", ["En Allemagne","En Italie","En France"],"En Italie"),
            new Question("Question mathématique: combien font 5x5 ?.", ["15", "25", "10"], "25")
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

    </script>

    </body>
    </html>
@endsection