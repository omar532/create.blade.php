@extends('layouts.test')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://jchamill.github.io/jquery-quiz/jquery.quiz-min.js"></script>
    <style>

        .back {
            background-image:url('https://image.freepik.com/vecteurs-libre/maison-bois-style-cartoon-trois-souris-fond-blanc_1308-51097.jpg');
            width: 600px;
            height: 500px;
            border-radius:500px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, .8);
            padding: 10px 50px 50px 50px;
            border: 2px solid #cbcbcb;
        }
        h1 {
            color: black;
        }
        .faded {
            color: #777;
        }
        #quiz-counter {
            color: #88449a;
        }
        .quiz-container {
            padding: 0.25em;
            max-width: 650px;
            margin: 1em auto;
        }

        .quiz-container a {
            text-decoration: none;
            color: #333;
        }

        #quiz-header,
        #quiz-start-screen,
        #quiz-results-screen,
        #quiz-counter {
            text-align: center;

        }

        .question {
            text-align: center;
            color: black;
            font-size: 1.25em;
        }

        .answers {
            text-align: center;
            list-style: none;
            padding: 0;
        }

        .answers a {
            text-align: center;
            display: block;
            padding: 0.5em 1em;
            margin-bottom: 0.5em;
            background: rgba(255, 255, 255, .8);
        }

        .answers a.correct {
            background: #090;
        }
        .answers a.incorrect {
            background: #c00;
        }

        .answers a.correct,
        .answers a.incorrect {
            color: #fff;
        }

        #quiz-controls {
            background: rgba(255, 255, 255, .8);
            color: #111;
            padding: 0.25em 0.5em 0.5em;
            text-align: center;
        }

        #quiz-response {}
        #quiz-results {
            font-size: 1.25em;
        }

        #quiz-buttons a,
        .quiz-container .quiz-button {
            display: inline-block;
            padding: 0.5em 1em;
            background: #88449a;
            color: #fff;
        }
        #quiz-buttons a {
            background: #fff;
            color: #333;
        }

        /* Quiz State Overrides */

        .quiz-results-state #quiz-controls {
            background: none;
            padding: 0;
        }
        .quiz-results-state #quiz-buttons a {
            background: #88449a;
            color: #fff;

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
    <div id="quiz">
        <div id="quiz-header">
            <h1>Quiz</h1>
            <p class="faded"></p>
        </div>
        <div id="quiz-start-screen">
            <p><a href="#" id="quiz-start-btn" class="quiz-button">Start</a></p>
            <canvas id="canvas"></canvas>
        </div>
    </div>
    </div>

    <script >
        $('#quiz').quiz({
            image:'#idimage',
            resultsScreen: '#results-screen',
            counter: true,
            homeButton: '#custom-home',
            counterFormat: 'Question %current of %total',
            questions: [
                {
                    'q': 'الفئران تأكل الجبن',
                    'options': [
                        'نعم',
                        'لا'
                    ],
                    'correctIndex': 0,
                    'correctResponse': 'Good job, that was obvious.',
                    'incorrectResponse': 'try again'
                },
                {
                    'q': 'أين يعيش الفأر',
                    'options': [
                        'في المنزل',
                        'في شاطئ بحر',
                         'في كوخ صغير'
                    ],
                    'correctIndex': 2,
                    'correctResponse': 'Good job, that was obvious.',
                    'incorrectResponse': 'try again'
                },
                {
                    'q': 'كيف يتنفس إل فار',
                    'options': [
                        'الانف',
                        'الخياشيم'
                    ],
                    'correctIndex': 0,
                    'correctResponse': 'Good job, that was obvious.',
                    'incorrectResponse': 'try again'},
                {
                    'q': 'question',
                    'options': [
                        'rep1',
                        'rep1',
                        'rep12'
                    ],
                    'correctIndex': 2,
                    'correctResponse': 'Good job, that was obvious.',
                    'incorrectResponse': 'try again'}
            ]

        });

    </script>
@endsection