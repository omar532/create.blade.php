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
           <input type="hidden" id="message" class="materialize-textarea" value="how many ball in photo"></input>
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
        <a class="btn btn-success" href="{{route('ColerQuiz')}}">Next</a>
    </center>
    <canvas id="canvas"></canvas>
    <script >
        // Creating questionss and answers
        //*****************************************************************************
        var question1 = {
            qImg: "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxIQEhAQEBIPDxAQDxAQEA8PDw8PEBAPFREXFxURExUYHSghGBomHRUVITEiJSkrMDAuFx8zODMtNygtLisBCgoKDg0OGhAQGi0lHyYtLS81Ky0tLS4vLS0rKy0tLS0vLS0tLy0tLS0tLS0rLy0tLS0tLS0tLSstLS0tLS0tLf/AABEIAOEA4QMBEQACEQEDEQH/xAAcAAEAAgMBAQEAAAAAAAAAAAAABAUCAwYBBwj/xABAEAACAQICBgYGBwgCAwAAAAAAAQIDEQQhBRIxQVFhBhNxgZGhIjJCUrHBFCMzYnKy0QdzgqLC4fDxY7MkQ1P/xAAbAQEAAgMBAQAAAAAAAAAAAAAAAwQBAgUGB//EADYRAAIBAgMECQQBBAIDAAAAAAABAgMRBCExBRJBURNhcZGhscHR8CIygeEjBhRCYjNSgpLx/9oADAMBAAIRAxEAPwD7iAAAAAAAAAAAAAAAAADXiMRCmtapKMIrbKclFeLMpN6G0YSk7RV2VFbpZgo5Oun+CFSovGMWjdUZvgWo7PxEv8e+y8zLD9KsFN2WIpp/8mtS/OkHSmuAlgMRHWD/ABn5FvCakk0008007prkyMqNNZMyBgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHJad6W2bpYW0pLKVd+lCL4QXtPns7SeFLjI6uG2fdb9XTlx/PLz7DkcQp1Za9WUqk/em9ZrkuC5InVlkjqw3YLdgrLqI1Wkja5LGRFlTM3JUyXorSNXCy1qM5QV84J3hLtjs79piUVLUir0IVlaav5959J0B0ghiYpO0am9bm+X6FOdNxPOYrCSovqLojKYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAOR6XaZbbwtJ2y+vmttmvsl3beTtxJ6UP8AJnVwOGSXSz/C9fY5+hhbLYStl6VQyrUbGExGVyrxJIi1Ahs2JwASMFipUpKUe9cUYauiOrTVSNmfT9AaUVeCu7yte/vLj2rf2riUpx3WeYxNB0pFqaFYAAAAAAAAAAAAAAAAAAAAAAAAAAAAELTOO+j0alXa4q0E9827RXi0bQjvOxNh6XS1FD5bifPcLG7bk3KTblKT2yk3dt95aZ3pu2S0LmhQyI2ynKeZD0grI2iTUczncTO7JkdKCI5kkMoIwYZscAaJl30Tx0qdTV560Vz4d6uu8iqxuilj6SlDePpMJqSTWaaTXYyoedas7MyBgAAAAAAAAAAAAAAAAAAAAAAAAAAA4/p/i7fR6O5udWX8KUY/ml4E9Fas62y6f3z7F87jnaFdIlaOhKDZaR0ikjTdKroNsqNI47WJIxsXKNKxUylckLaR4DJspmDVm9IwRkvRcLTjJbmjWTyIa7vBo+maOleFuD8nn8ym9TzdVfUSjBGAAAAAAAAAAAAAAAAAAAAAAAAAAAfMP2lYhrGQjuWEptdrq1b/AJUWaOh6TZEE8O3/ALPyRzKxjJbnS6NG2OOb3mUzXo0Z9ZcyLWBkHqAMoysYNWhLEGDG4SdH4uzNZIjq07o+m6Cra0L33Rfk/wBCrPJnmsTHdkWaZpcrnoAAAAAAAAAAAAAAAAAAAAABT9JOkmHwENetJuUr9XRhZ1KjXBblzdkTUaE6rtEjqVY01eR8o09+0THYhtUpLCU90aNnUa+9Uavf8KidejgKUfuzZy62Nm/tyOTxGMrVM6latUfGpVqTfjJlxU4rRIqOtN6tmuNecXdSfY3deYdOL1RJSxVannCbXY2WWG0nCWVWLg/fp5rvi/lYq1MHF/advCf1HiabtU+pdfvr5k6dJpKaanB7Jxzjfg+D5MoTpyg8z12C2nQxa+h2fJ+nPz6jOjWNUy+4k2E7m5G0JTsYFiLOsa3N90s9E6Hq1/SXow9+W/8ACt5z8XtKlh/p1lyXq+HmUMVj6dD6dZcvd/GdRgej1Knm4674zz8thw6u0cTVetlyWXjr4nDrY+vV/wArLksvHXxLXqVbYvApzbepSauapUbZrJ8VkyDR3Rq4m2hpKrT9pzj7s8/CW1FmjtCtTet1yfvqa5ovsBpCFZZZSW2D2rmuKO9hsXTrr6deRupXJZaMgAAAAAAAAAAAAAAAAp+lWn4YChKtJa029SjTvZ1KrWS5JZtvgmTUKLqz3UR1aipx3mfDsdiauJqTr15OdSbu29iW6MVuityO/CEYR3Y6HEqVJTd2Q69OxLFlaaIrNjCMZIGyMUgCbo3HzoyvHOLylB5xkuDRpUpqasyWlWlSlvRZfyw0ZxVajd027SjtdKXuviuDORWpODPfbI2wsTHcqP6ufP8AfmewTjtI0zt3TNVaqGzZIvOjGgeutWqr6v2IP2+b+78ezbxNo7QcH0VJ58Xy6l1+Xbpydo4/o/4qbz4vl1dvl26d3QorYskthxadO554lqgW1RVjBpqwsV6sLAiVGUZswaGRmGKbcZKUXZp3TRtTqShJSi80a2OpwWJ6yKlv3rmesw1dVoKXE3JBYAAAAAAAAAAAAAAAB8X6eaUeMxs4xd6WGbo01u1k/rJ98lbsgjuYOl0dK71efscjF1N+pZaI0YPRDkrm8qtiKNO5C0ro/UTJKdS5DVhZHOzRZIEYgyEZDM1AwDrOiM9WVnnCa1ZxexplPExui1hKrpzTRbac0f1d0s1tT4xew5EnY+g4HFdNBN68So0Lo76RWUH6i9Kb+6t3fs8SnjcX0FFyWryXb+i3jMV0FHeWryXb+j6RSiopJKySsktiR5VPizybz1JNKpYnp1EmCR16LbrqxgiV61yhWrXMESUim2YMTAABZaGr6srbmdXZlbdnuhF+eiMgAAAAAAAAAAAAAh6ZxnUYevX/APlRqVEuLjBtLyN6cd+ajzZrOW7Fy5HwvRsbNN5ve3tb3tnoZ6HCjm7s6zDYyMY7thSlBtluMkkc5p/HKV7FujCxSrzucxNloroxBk9sDBtpGGbxzLrRWJ1GQVI3N7WzOrx2NVbDKe103qy/DLZ5/E5OIpuLPU7CxG9PcfHzXxm3ohQUacqm+pJv+GOSXxfeeP2rX36+5wivF5v0Lm1K2/W3OEV4vN+i/B0esc/eOcNcxvC566hjfZi5rcjVsweGDB6kDJlqm1jJswrtNdtiXDvdqIHT0pXinvtn27z1tN3imDM3AAAAAAAAAAAABz/T+dtH4q3uRXc6kU/iWMIr1okGJ/4pdh8ZpVLHeaOKmbKmOaW0woBzKnE1nJkyViu3vMjmTIAPUDBupIwzMHmTqcciNstJXJuicS9XE0m8pUJyXbFa39JXxMN6PziXNmzdKvF9afidtoa0aVKPCnBd9j5XWqb9WUubfmdWtU36spc2/MtYsxc0M0YMHgABgAyZRRsgbLG9jIpr0l2oQ+9A6bDequ2X5metofZ3+bBtJQAAAAAAAAAAAAU3TPDupgcZFK7+j1JJcXBayX8pPhpbtWL6yKur05LqPhCqZHorHnt4j1alzZIjbuaGzJk8BkAC4AjXszDNoxzJVPE32Edi9CJ7gKzVSo/+Cvfs6qRrU+0npx+tWPoGi6rcIP7sfgfIZKzsWk87MuadSxrckuboVTZMzc2pmQDIPUDJsijdIyZ2JLA3YajeS7SehScpoF/QXorx8Xc9LSVoL5qDYSAAAAAAAAAAAAA8nFNNPNNNNcUwD85acwDwuIr4Z3+pqSjG+1w2wl3xcX3nqKNTpIKXM81Xp7lRxK9skIzwGTwAAEetWsatksIXI9PWnK0U2+CIqlWNOO9N2RcoYepWmoU43fIu8HgGs5PPgtnicPEbZelFfl+3v3HsMH/TcUr4mX/jH1fH8W7WSfo6V7K100+ae1PijmVMZiKn3Tfl5Heo7NwlL7aUfyrvvd2ZQxdWDWrUqRtsSnK3hexRlRpy1iu4svBYaazpx/8AVexaYDpRWg0qmrVjvbSjPuay8irV2fTl9uTOdidg4eor07xfeu5+51uA0hCtFSg+57UcutQnSf1d55bF4KrhpWmvzwLClUIkyqmb0zdGxmjZGTdTiTRiZNyiTKJkn4Clv7jqYOlxMFodYAAAAAAAAAAAAAAAHzX9rvR1zjHH0ld04qniEtrpX9Gp/C20+TW5HU2dXs+jfHQ52Poby31wPlR2DkAGDxgyaq07GGbxjchwpyqSUY5t+C5sr1q0aUHOeiOjhMLUxFRUqazfh1vqOo0bo1U1ZZt+tLe3+h5LFYqeIleWnBcj6LgcDSwVPchrxfF/rkvUsOosVS3vkaqrGSaDINQyWUYGDJL0dj5UZKUdm+O5ms4KSsyviMPCtBxkjvtHY2NWKlF7V/vvODisM6MrrT5keFx+Blhp9RZ0JEEWU0S4RJ4xNiVTgW6cDJk1dpLebNNvdQLfB07LyXPizu4aFomCSWQAAAAAAAAAAAAAAAY1IKScZJSjJNSi0mmntTW9BOwPiHT7obLATdWinLCTfo75UG/YlvceEu552b7eFx9ObVOckpvRc+z1ONisG4fXFZeRyCZ0LlCx5Ji4RBxNQ0cizCJfaAwOrHXa9KefZHcvmeX2piulq7i0j58fY+g7DwKw+H6SS+qefYuC9X+jqMDhbnMsdGpUsT6+j7K5tukEa12c5pGOrka2OpRdyrkbFxHiNTDM9QGLlv0bx3V1NRu0ZvK+yMtz/wA4siq01Ui4sobQw0a1J3O/wzvZr/T3o8+4OE3F8Dw06bhJxfAtKES7SiYsSOSzZaz0QGFxNHrepdSKqb43s3f2IvZfltJ8MqXSbjkr/Ml6/LTf21Xo+l3Xu8/nDr0L1I7WhAAAAAAAAAAAAAAAAACNisTq5L1vJHJ2jtHoP46ec/Bdb9F8ctOnvZvQq61PWvrelrJqWtndcHyPJ1I1JT6SUm5c+P66racC0rWsfP8ApH+z+Mm6mDcacs26E2+rb+5L2ex5dh6rZn9WTpWp4xby/wCy1/K49qz7WcvE7KjP6qWT5cD59pLC1KEnTrU50p+7NWvzi9klzVz3OHxdHEw6SjNSXV68uxnEnh6lKVpqxWUKfWVIx4yz7Fm/IixVXo6cp8l48Do7Ow39xiIUno3n2LN+B2dJ2seQPpskWuj8co7TMSpVouWhMxul01kbtkdLCu5y2NxGszU69KFkQwTmSMM1ZIgjQibMXGzTW53Mmb3Vj6JoPE60Iv3op96yfwT7zlY+naSmuPoeM2pS3Kl/x7fOov6dVRV5tRXi32I1pyUVebsjn06cqjtFXIWN0pJpxp3hF5OXtv8AQiq4xtbtPJeL9jrYfARj9VTN8uH7Kd4RPmUd86vStHS9H9MyTVGs3JPKFR7U/dk9/ad7Zu022qVV9j9H7nIxuDTTqU12r1XsdOegOOAAAAAAAAAAAAADXXq6sW/BcWVcZiVh6LqceC5t6fvqNoR3nYrEr5vNvNvmeTjCUm5Sd282y31CSMzhkYuaZxKFSJImQtIYCnXg6danCrB+zOKkr8VwfM1pVquHnv0pOL5p2EoxmrSVz5z0i6GUMG44mhKpFSn1fUzevFOUW7xk816ryd9p6fB7dxGMi6FZJ5X3lk8mtVp3WLeyMFThid+PBP0RVuZbuen3TVKsZN1AwlVbMokUEjU2ZNzwGTNGGaMk0zRkUjfRo3ZmJHKVju+j2GtRjycl4q/9JFi6d6f5PPY5RqVLS7fneS6lPM4VRWNoWStFWRpkis2SpnhoDFoynY2Oz0Niuspq+copJ8+DPZ7PxHTUU3qjz+KpdHUdtCeXisAAAAAAAAAAAAQcdK8lHgr97/x+J5/a89+tGlyV/wAvJdyv3likrJs1xiQ06WRls8mjWrCyMpkeZx6upKjXIrs2Ryf7Qo/+NB+7iIN9jhNfNHQ2O7V2v9X5o62yH/M1/q/NHz5zPSWPRWNc8zJskeBGTw2MgAyias1ZMoI0ZBIsMMrNGY6kE3c7vQlRdSvxfJmcTJKkzg4iL6UV55nnK8sySCNDZVJQkDAsAXfRutaTju2eP90jubGq2k4nPx8Lq50p6U5AAAAAAAAAAAABXVs5y7UvJHmcR9WLqN80vBFmOUUbYouwSSNGaqrKeKkkjeJEkzhVHdkyMWQsyUXTHC9ZhK6W2MVVVvuSUn5JljZ9TcxMW+OXfkdDZ1TcxEXzy78j5SetPWHoMHgMnhsZAYMoGphljhImjKtRk6rGyMEEXdnQ6MrOFKnHfquT73l8PMpY+taMY/koVIKVSUidGdzizlcjasemgM4oykaszaNmjUm6Ddpv+F+EkX9mO1X5zK+LV4HXHrzhgAAAAAAAAAAAFbWynLt+SPK4l7uKqLr9EWo/ajzrB/cNIbpqnMoVqzkbpGplJs3PDANdSN7p5p5NcURvJmydj49pvRzwtepR9mLvTfGk/Vfy7Uz2GFrqvSU+/t4ns8NXVekp9/bxIcSwTMxYMnhsjJ7YwzBtpQNWaSZcYCkaFKrImxoa84x3bZPgltYRA57sWy66lpp2tGSTi001qpJWut6yTXE4eNk5VN7g9Hwt81XArxmrNcVr88iVBFEjZsSBqbIokSNGzNo2sa3J2haXpN84rxkjobNg+kv2eZWxcvpOqPVnGAAAAAAAAAAAAK/HRtJP3l5r/Eea2tDcxClwkvFa+DRYpO8bEaTOVOZMkYMryZk8IzIMA8aMNGTnOmGgPpVLWgl11K7h99PbTfbbLn2s6GzsR0Ck5X3bpPkr3z9P3Y6Gz8b0FS0vtevv79R8xWV00002mmrNNbU1uZ6S99D1N080YtGTZBGwM4xMM1bJ2FokbZXnItqOXaYKksyzw9LVVvafrP8Ap/X/AGc/G4jdXRx1evzrIPue9w4e5YUYWVud7brnLquMVuJ3tq+F+rs58eyxX3nJ7z/HZ1+3A3ohBlBGUaskQiTRRG2SKVK5Yp07kMp2LrRmGtbtu/l/nI7uBw+7Z/k5+IqXLQ6pTAAAAAAAAAAAANGMpa0ctqzX6HO2nhnXoPd+5Zr2/Ky7bElOW7Iqrnjt66ui2eGpkGADUAAxcrd+VuPIs4XeU21pbPlu8U1xvolzsaytY5Dpj0Vda+Iw6+uSvUpr/wBqXtR+/wDHt23dn4x00qdTTg+X68jtbP2h0f8AHU+3g+X68j54d656JMXMmTbCYaNWiVRxFiMhlAvNE0m/Te3dy/uUsVilSVlqUqueXAu6FI4cnvZsrykTpy1km/W2N+8uPb/YkqVFUSk/u49fX28+eT1uVYxcXZaeXV2eRikQm9zfSgSwiRyZKjTLUYWIXIk4JXlbxLWFW9OxDVdlc6GhGy7fhuPSUo2icubuzYSGgAAAAAAAAAAAAAKzHYfVesvVe3k/0PJ7XwDoydaC+l69T59j8H25WqVS+TIpxiY9NgeGjAAPUSRfAwZEySMHG9LuiX0iTrYZJV2nKdNWSrW2tblPye/idXZ9WUo7rzzSX5Tfozq4HaXQ2p1ft58v15HzqrBxbjJOMotqUZJxlFramnsZ07no4zTV08jFMXNrl7ofREpJVailGD1XTvFrrE9b0ovh6Lz5lXFVHTp7y6vG+fgUquJW/wBHHXO/Va3udThqCSSSslsR5+Um3dlOcyZGJoQNmyMDZRNGzdCkSRhc0ciZRolynSIJTM5K+SzZvJN/THU1Ttmyz0Zg7ZvZvfvPguR1sDhN1Xf/AN/RTxFa+RanWKQAAAAAAAAAAAAAAB40YaTVmCuxOBazhmvd3rsPL47YsoPfw6uv+vFdnNdXdfQswrXykRL/AOntRw9HZ6k4DB4agXM3A1iRNmCRgI/WRf3Zpdvov4fE9JsSn9M5W4rvs/R+JXrPQjdJejeFxSU61NdZeEeui3Caje2bXrJK+TudqdKM9US4bH18PlTlly1XzsOR6DdHcOpzhicNiKtWFVqnXqYerHCVIqO1J5bVL1uKsQ06Ub5q51cdj68qalCaSazSa3l69x03THCOcdeOzD6kmls1JOUX4Wi+y5W2tSc6F1wd/Qo7KqqNZxf+St+dfE52nUPKSR2ZRJEJGpG0SaLJoEMiZTaLcLEDuSqdNytuvyu32It06Up6EMpJFlhdH2zlly3vte7sX9jp0MEo5y+fPj4FSpiL6E9I6KViqegAAAAAAAAAAAAAAAAAAGqth4z9ZZ8dj8SricFQxC/kjfr0ffqbRnKOhCq6Oa9V35SyfijhV9gzjnRlfqlk+9e35J411xREqU5R9ZNc2svHYcithatH/kg118O9ZeJKpJ6MwIlFaoyZU4OTss2/8u+RLRpSqTUIK7fy76vmphtJXZZqkoOkl99X4txu35Ht8NQjQpKmuHi+LKcpbzuZ4xX1FxqJfyt/InNTOi3ed9zX5UAYRpqTrKSTTag09jjqK6/mZhpNWZmLcXdanA6a0e8LUUG04z1nSbau4q101xV1meSxuEeHn/q9GepwmIWIhvJZrXt/ZFp19ivm9iWbZRSu7ImlAu8Bo2vUs1CUVxmtReefgi9Q2dXqZ7tl15fvwOfWxNGHG/ZmX+C0Pq5zld8Ir5vb5Haw+zIwzm7v584HMq4xy+1FnTpRj6qS+L7WdKMIx0RUlJy1MzY1AAAAAAAAAAAAAAAAAAAAAAAAABplhYPNwjfjZFSeBw03eVON+xGynJcSHXwqUlOn9WrxjKUdrzSyWzftKtTZkFUjKh9HNx8FbTtfZqbqq7fVmSq0bOjtdptXbu/s5nTjHdViJnmLdnTsrtSk7bL2py/U2AwcWnU1nrS11d7F6kXZcswDZh/afGcvJ2+QBVaY0dUnUpVoVGpUm3Ck4QcWnqqUdZK6vZZ52sVa1CU5qalpwa+MuUMTCFOVOUcpcU8+rq8i1w8LJNxjGT22sWUkuBUbb4m0yYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABCdVunNNWnTjmtzsrxlHk7fFbgDdifYfCpHzuvmAKv2lP8ADN/BfMA14SS1ppPbKTtwStH5eQBuw+z+Kf52AYYmVruyllFWbsld7W924AywqernJSzvdXslwTbdwDcAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADS1rKTytKNlvus8/MA1616UJfupfzRbAGI1teOrZPUmrvO15Qztv2ADR1NKF9rlKbcntl6Ts33WAN1D1V4+IBqxDerJptekvVV5WyVlkwDLCRSj6KlHO7176zfF3AN4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIOiPUf72r/ANjAMqf2Ef3UfggDc/tF+7l+ZAHmB+zh+FAGyj6sexACnsf4pfFgGYAAAAAAAAAAAAAAAAAP/9k=",
            question: "how many ball in photo",
            answers: ["6", "7", "8"],
            correct: 0
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