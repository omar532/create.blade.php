
<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://jchamill.github.io/jquery-quiz/jquery.quiz-min.js"></script>
<head lang="en">
    <meta charset="UTF-8">
    <title>Quiz Science</title>
</head>
<body>
<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,500,700,800');
    *{
        box-sizing: border-box
    }
    html, body{
        margin:0;
        padding:0;
        height:100%;
        color:#14152C;
        font-family: 'Raleway', sans-serif;

    }
    .bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #fff;
        padding: 15px 10px;
        box-shadow: 0px -2px 12px rgba(0,0,0,0.1);
    }

    .bottom__container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .progress {
        width: 70%;
        height: 10px;
        position: relative;
        border-radius: 5px;
        overflow:hidden;
        background-color: #ecedf5;
    }
    .progress__inner {
        position: absolute;
        top: 10%;
        border-radius: 5px;
        height: 100%;
        left: 0;
        width: 0    ;
        background-color: #5861af;
        transition:.4s width linear
    }

    .navigation__btn path{
        fill:#A7AACB
    }
    .navigation {
        display: flex;
        align-items: center;
    }

    .navigation__btn {
        display: flex;
        align-items: center;
        width: 44px;
        border: 1px solid #A7AACB;
        justify-content: center;
        height: 44px;
    }

    .navigation__btn--left{
        border-top-left-radius:500px;
        border-bottom-left-radius:6px
    }

    .navigation__btn--right{
        border-top-right-radius:6px;
        border-bottom-right-radius:500px
    }

    .quiz__question{
        font-weight:900;
        letter-spacing:1px;
        margin-top: 0;
        font-size: 34px;
        margin-bottom: 50px;
    }

    .container {
        display: flex;
        height: calc(100% - 74px);
        width: 100%;
        align-items: center;
        justify-content: center;
        padding: 15px 10px;
    }
    .answer:first-of-type{
        margin-right:15px;
    }
    .answer__input {
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        width: 1px;
        height: 1px;
        position: absolute;
        outline:none !important;
    }

    .answer__label {
        border: 1px solid #A7AACB;
        display: inline-block;
        width: 200px;
        height: 200px;
    }

    .answer {
        display: inline-block;
        margin-right:10px;
    }



    .quiz__step {
        text-align: center;
    }

    .answer__input:checked + .answer__label{
        border-color:#5861af;
        color:#14152C;
        box-shadow: 0px 0px 1px 4px rgba(88,97,175, 0.2)
    }

    .answer__input:checked + .answer__label .answer__tick{
        opacity:1;
        visibility:visible;
    }

    .answer__char {
        line-height: 24px;
        display: inline-block;
        width: 26px;
        text-align: center;
        font-size: 13px;
        border-radius: 4px;
        color: #c8cae0;
        border: 1px solid #c8cae0;
        font-weight: 600;
        vertical-align: middle;
        margin-right: 15px;
    }
    .answer__tick {
        display: inline-block;
        vertical-align: middle;
        background-color: #5861af;
        margin-left: 20px;
        line-height: 14px;
        border-radius: 50%;
        padding: 4px;
        opacity:0;
        visible:hidden;
    }

    .answer__tick path{
        fill:#fff
    }
    .quiz__inner {
        max-width: 800px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .quiz__step:not(.quiz__step--current){
        visibility:hidden;
        opacity:0;
        display:none;
    }
    .question__emoji{
        font-size:45px;
        margin-bottom:15px;
        display: inline-block;
        margin-right: 15px;
    }
    .navigation__btn--disabled {
        opacity: 0.4;
    }
    .submit__container {
        margin-top: 25px;
    }
    .submit {
        background-color: #5861af;
        line-height: 50px;
        display: inline-block;
        border-radius: 25px;
        padding: 0 15px;
        font-size: 13px;
        text-decoration: none;
        color: #fff;
        letter-spacing: 1px;
        box-shadow: 0px 6px 11px rgba(88,97,175, 0.6);
        min-width: 130px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .thanks__tick {
        line-height: 50px;
        width: 50px;
        font-size: 25px;
        color: #fff;
        background-color: #5861af;
        border-radius: 50%;
        display: inline-block;
        text-align: center;
    }
    .thanks__title {
        font-weight: 900;
        letter-spacing: 1px;
        margin-top: 15px;
        text-align: center;
        font-size: 40px;
    }
    .thanks{
        text-align:center;
    }
    .bh {
        display: block;
        width: 115px;
        height: 45px;
        left: 1000%;
        background:green;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        line-height: 25px;

    }
</style>
<div style="justify-content: center;align-items: center;display: flex">
<p>&#10006;</p>
<div class="progress">
    <div class="progress__inner"></div>
</div>
<p>&#9989;</p>
</div>
<div class="container">
    <div class="quiz__inner">
        <div data-question="1" class="quiz__step--1 quiz__step--current quiz__step">
            <h1 class="quiz__question">comment dit-on "homme" ? </h1>
            <div style="justify-content: center;align-items: center;display: flex">
                <div class="answer">
                    <input class="answer__input" type="radio" id="s" name="quiz1" value="0">
                    <label class="answer__label"for="s" ><img class="speak"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/avatar.png')}}"/><br>
                        <span class="speak">man</span>
                        <form class="col s8 offset-s2">
                            <input type="hidden" id="rate" min="1" max="100" value="10" />
                            <input type="hidden" id="pitch" min="0" max="2" value="1" />
                            <input type="hidden" id="message" class="materialize-textarea" value="man"/>
                        </form></label>
                </div>
                <div class="answer">
                    <input class="answer__input" type="radio" id="q0" name="quiz1" value="1">
                    <label class="answer__label"for="q0" ><img class="speak2"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/avatar2.png')}}"/><br>
                        <span class="speak2">Women</span>
                        <form class="col s8 offset-s2">
                            <input type="hidden" id="rate" min="1" max="100" value="10" />
                            <input type="hidden" id="pitch" min="0" max="2" value="1" />
                            <input type="hidden" id="message2" class="materialize-textarea" value="women"/>
                        </form></label>
                </div>
                <div class="answer">
                    <input class="answer__input" type="radio" id="q1" name="quiz1" value="2">
                    <label class="answer__label" for="q1"><img class="speak3"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/avatar3.png')}}"/><br>
                        <span class="speak3">girl</span>
                        <form class="col s8 offset-s2">
                            <input type="hidden" id="rate" min="1" max="100" value="10" />
                            <input type="hidden" id="pitch" min="0" max="2" value="1" />
                            <input type="hidden" id="message3" class="materialize-textarea" value="girl"/>
                        </form></label>
                </div>

            </div>
            <br>
            <hr>
            <div style="justify-content: center;align-items: center;display: flex">
            <section class="bottom__container">
                   <div class="navigation">
                       <div class="navigation__btn navigation__btn--left">
                           <svg width="20" height="20" viewBox="0 0 24 24">
                               <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                           </svg></div>
                       <div class="navigation__btn navigation__btn--right">
                           <svg width="20" height="20" viewBox="0 0 24 24">
                               <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                           </svg>
                       </div>
                   </div>
               </section>
                <a href="#" class="bh check">Vérifier</a></div>
        </div>
        <div data-question="2" class="quiz__step--2 quiz__step">
            <h1 class="quiz__question">comment dit-on "chien" ?</h1>
            <div style="justify-content: center;align-items: center;display: flex">
            <div class="answer">
                <input class="answer__input" type="radio" id="s1" name="quiz1" value="4"/>
                <label  class="answer__label" for="s1">
                    <img class="speak4"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/dog.png')}}"/>
                    <br> <span class="speak4">Dog</span>
                    <form class="col s8 offset-s2">
                        <input type="hidden" id="rate" min="1" max="100" value="10" />
                        <input type="hidden" id="pitch" min="0" max="2" value="1" />
                        <input type="hidden" id="message4" class="materialize-textarea" value="Dog"/>
                    </form></label>
            </div>
            <div class="answer">
                <input class="answer__input" type="radio" id="s2" name="quiz1" value="5"/>
                <label  class="answer__label" for="s2"><img class="speak5"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/cat1.png')}}"/><br> <span class="speak5">Cat</span>
                    <form class="col s8 offset-s2">
                        <input type="hidden" id="rate" min="1" max="100" value="10" />
                        <input type="hidden" id="pitch" min="0" max="2" value="1" />
                        <input type="hidden" id="message5" class="materialize-textarea" value="Cat"/>
                    </form></label>
            </div>

            <div class="answer">
                <input class="answer__input" type="radio" id="s3" name="quiz1" value="6"/>
                <label  class="answer__label" for="s3"><img class="speak6"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/mouse.png')}}"/><br> <span class="speak6">Mouse</span>
                    <form class="col s8 offset-s2">
                        <input type="hidden" id="rate" min="1" max="100" value="10" />
                        <input type="hidden" id="pitch" min="0" max="2" value="1" />
                        <input type="hidden" id="message6" class="materialize-textarea" value="Mouse"/>
                    </form></label>
            </div>
            <div class="answer__tick">
                <svg width="14" height="14" viewBox="0 0 24 24">
                    <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path>
                </svg>
            </div></div>
            <br>
            <hr>
            <div style="justify-content: center;align-items: center;display: flex">
                <section class="bottom__container">
                    <div class="navigation">
                        <div class="navigation__btn navigation__btn--left">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                            </svg></div>
                        <div class="navigation__btn navigation__btn--right">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                            </svg>
                        </div>
                    </div>
                </section>
                <a href="#" class="bh check1">Vérifier</a></div>
        </div>

    </div>
    <div data-question="3" class="quiz__step--3 quiz__step">
        <h1 class="quiz__question">comment dit-on "personne" ?</h1>
        <div style="justify-content: center;align-items: center;display: flex">

        <div class="answer">
            <input  class="answer__input" type="radio" id="s7" name="quiz1" value="7"/>
            <label  class="answer__label" for="s7"><img class="speak7"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/home.jpg')}}"/><br> <span class="speak7">Home</span>
                <form class="col s8 offset-s2">
                    <input type="hidden" id="rate" min="1" max="100" value="10" />
                    <input type="hidden" id="pitch" min="0" max="2" value="1" />
                    <input type="hidden" id="message7" class="materialize-textarea" value="HOME"/>
                </form></label>
        </div>
        <div class="answer">
            <input  class="answer__input" type="radio" id="s8" name="quiz1" value="8"/>
            <label  class="answer__label" for="s8"><img class="speak8"  style="width:150px;height: 150px;border-radius:500px;"  src="{{asset('dist/img/homme.jpg')}}"/><br> <span class="speak8">people</span>
                <form class="col s8 offset-s2">
                    <input type="hidden" id="rate" min="1" max="100" value="10" />
                    <input type="hidden" id="pitch" min="0" max="2" value="1" />
                    <input type="hidden" id="message8" class="materialize-textarea" value="people"/>
                </form></label>
        </div>
        <div class="answer__tick">
            <svg width="14" height="14" viewBox="0 0 24 24">
                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path>
            </svg>
        </div>
        </div>
        <br>
        <hr>
        <div style="justify-content: center;align-items: center;display: flex">
            <section class="bottom__container">
                <div class="navigation">
                    <div class="navigation__btn navigation__btn--left">
                        <svg width="20" height="20" viewBox="0 0 24 24">
                            <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                        </svg></div>
                    <div class="navigation__btn navigation__btn--right">
                        <svg width="20" height="20" viewBox="0 0 24 24">
                            <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                        </svg>
                    </div>
                </div>
            </section>
            <a href="#" class="bh check2">Vérifier</a></div>
    </div>
    <div data-question="4" class="quiz__step--4 quiz__step quiz__summary">
        <h1 class="quiz__question">Summary</h1>
        <div id="summary"></div>
        <div class="submit__container">
            <a href="#" class="submit">Submit</a>
        </div>
    </div>
</div>
<script>
    const numberSteps = $('.quiz__step').length - 1;
    let disableButtons = false;
    const tick = '<div class="answer__tick"><svg width="14" height="14" viewBox="0 0 24 24"><path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path></svg></div>';
    let thanks = '<div class="thanks"><div class="thanks__tick">✔ </div><h1 class="thanks__title">Thank you!</h1></div>';
    $('.answer__input').on('change', function(e) {

        if($(this).next().children('.answer__tick').length>0){
            return false
        }
        $(this).next().append(tick)
    });

    $('.navigation__btn--right').click(function(e){
        let currentIndex = Number($('.quiz__step--current').attr('data-question'));
        if($('.quiz__step--current input:checked').length == 0){
            //console.log('input empty');
            return false;
        }
        //console.log({'currentIndex': currentIndex, 'numberSteps': numberSteps-1})
        if(currentIndex == numberSteps + 1 || disableButtons==true){
            //console.log('last')
            return false;
        }
        if(currentIndex + 1 == numberSteps + 1 ){
            $(this).addClass('navigation__btn--disabled');
        }
        if(currentIndex == numberSteps){
            $('.summary__item').remove();
            $('.quiz__step:not(.quiz__summary)').each(function(index, item){
                console.log(item)
                let icon = $(item).children('.question__emoji').text()
                let answer = $(item).children('.answer').find('input:checked').val();
                let node = '<div class="summary__item"><div class="question__emoji">'+icon+'</div>'+answer+'</div>'
                $('#summary').append(node)
            })
        }
        const percentage = (currentIndex * 100)/ numberSteps;
        $('.progress__inner').width(percentage+ '%');
        console.log('input ok')
        $('.quiz__step--current').hide('300');
        $('.quiz__step--current').removeClass('quiz__step--current');
        $('.quiz__step--'+(currentIndex+1)).show('300').addClass('quiz__step--current');
        currentIndex = Number($('.quiz__step--current').attr('data-question'));
        if(currentIndex > 1 ){
            $('.navigation__btn--left').removeClass('navigation__btn--disabled');
        }
    });
    $('.navigation__btn--left').click(function(e){
        let currentIndex = Number($('.quiz__step--current').attr('data-question'));
        console.log({'currentIndex': currentIndex, 'numberSteps': numberSteps-1})
        if(currentIndex == 1 || disableButtons==true){
            console.log('first')
            $(this).addClass('navigation__btn--disabled');
            return false;
        }
        $('.navigation__btn--right').removeClass('navigation__btn--disabled')

        console.log('input ok')
        $('.quiz__step--current').hide('300');
        $('.quiz__step--current').removeClass('quiz__step--current');
        $('.quiz__step--'+(currentIndex-1)).show('300').addClass('quiz__step--current');
        currentIndex = Number($('.quiz__step--current').attr('data-question'));
        if(currentIndex == 1 ){
            $(this).addClass('navigation__btn--disabled');
        }
        const percentage = ((currentIndex-1)  * 100)/ numberSteps+1;
        $('.progress__inner').width(percentage+ '%');
        $('.quiz__step--current').keyup(keypressEvent);
    });
    $('.submit').click(function(e){
        e.preventDefault();
        $('.quiz').remove();
        $(thanks).appendTo('.container');
        disableButtons=true;
        $('.navigation__btn').addClass('navigation__btn--disabled')
    });

    $('.check').click(function(){
            alert($(".answer__input:checked").val());
    });

    $('.check1').click(function(){
        alert($(".answer__input:checked").val());
    });
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

            $('.speak').click(function(){

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

        $('.speak2').click(function(){
            var text = $('#message2').val();
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
        $('.speak3').click(function(){
            var text = $('#message3').val();
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
        $('.speak4').click(function(){
            var text = $('#message4').val();
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
        $('.speak5').click(function(){
            var text = $('#message5').val();
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
        $('.speak6').click(function(){
            var text = $('#message6').val();
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
        $('.speak7').click(function(){
            var text = $('#message7').val();
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
        $('.speak8').click(function(){
            var text = $('#message8').val();
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
    });
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
