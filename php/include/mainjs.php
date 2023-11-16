
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.1/ScrollToPlugin.min.js"></script>
<script>

    // 롤링 배너 복제본 생성
    let roller = document.querySelector('.imgslider');
    roller.id = 'imgSlider1'; // 아이디 부여

    let clone = roller.cloneNode(true)
    // cloneNode : 노드 복제. 기본값은 false. 자식 노드까지 복제를 원하면 true 사용
    clone.id = 'imgSlider2';
    document.querySelector('.img__wrap').appendChild(clone); // wrap 하위 자식으로 부착

    document.querySelector('#imgSlider1').style.left = '0px';
    document.querySelector('#imgSlider2').style.left = document.querySelector('.imgslider').offsetWidth + 'px';    
    // offsetWidth : 요소의 크기 확인(margin을 제외한 padding값, border값까지 계산한 값)

    roller.classList.add('original');
    clone.classList.add('clone');

    // // gsap 효과를 적용할 요소 선택
    // const quizInner = document.querySelector('.quiz__inner');

    // // gsap 효과 정의
    // const quizTween = gsap.timeline();

    // quizTween
    //     .from(quizInner, { opacity: 0, scale: 0.5, duration: 1 })
    //     .to(quizInner, { opacity: 1, scale: 1, duration: 1 });

    // // ScrollTrigger를 사용하여 스크롤 트리거 설정
    // ScrollTrigger.create({
    //     trigger: quizInner,
    //     start: "top 50%",
    //     end: "bottom bottom",
    //     animation: quizTween,
    //     pin : true,
    // });
    
    //슬라이드 
    $(document).ready(function () {
        for (var i = 1; i <= $('.slider__slide').length; i++) {
            $('.slider__indicators').append('<div class="slider__indicator" data-slide="' + i + '"></div>')
        }
        setTimeout(function () {
            $('.slider__wrap').addClass('slider__wrap--hacked');
        }, 1000);

        var isPaused = false; // 일시 중지 상태를 저장하는 변수

        function goToSlide(number) {
            $('.slider__slide').removeClass('slider__slide--active');
            $('.slider__slide[data-slide=' + number + ']').addClass('slider__slide--active');
        }

        function autoSlide() {
            if (!isPaused) { // isPaused가 false인 경우에만 슬라이드 전환
                var currentSlide = Number($('.slider__slide--active').data('slide'));
                var totalSlides = $('.slider__slide').length;
                currentSlide++;

                if (currentSlide > totalSlides) {
                    currentSlide = 1;
                }
                goToSlide(currentSlide);
            }
        }

        // 3초(3000ms)마다 autoSlide 함수를 호출하여 슬라이드를 변경
        var autoSlideInterval = setInterval(autoSlide, 4000);

        // 다음 슬라이드로 이동하는 클릭 핸들러
        $('.slider__next, .go-to-next').on('click', function () {
            var currentSlide = Number($('.slider__slide--active').data('slide'));
            var totalSlides = $('.slider__slide').length;
            currentSlide++;

            if (currentSlide > totalSlides) {
                currentSlide = 1;
            }
            goToSlide(currentSlide);
        });

        // "일시 중지" 버튼 클릭 핸들러
        $('.pauseButton').on('click', function () {
            isPaused = true; // 슬라이드 일시 중지
        });

        // "다시 시작" 버튼 클릭 핸들러
        $('.resumeButton').on('click', function () {
            isPaused = false; // 슬라이드 다시 시작
        });
    });

    $(document).ready(function() {
    var startPage = $('.quiz__contants.q1');
    var quizPage = $('.quiz__contants.q2');
    var correctCount = 0;
    var userAnswers = [];
    var currentQuestionIndex = 0;
    var quizData = [];
    var quiz;
    var questionNumber;

    $('.quiz__btn').click(function() {
        startPage.hide();
        quizPage.show();
        loadQuizData();
    });

    function loadQuizData() {
        $.getJSON('../../assets/json/quiz.json', function(data) {
            quizData = data;
            loadQuiz(currentQuestionIndex);
        });
    }

    function loadQuiz(questionIndex) {
        quiz = quizData[questionIndex];
        questionNumber = questionIndex + 1;
        renderQuiz(quiz, questionNumber);
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function renderOptions(quiz) {
        var shuffledOptions = shuffleArray([quiz.correct_answer].concat(quiz.incorrect_answers));
        var optionsHtml = $.map(shuffledOptions, function(option) {
            return '<div class="op">' + option + '</div>';
        }).join('');
        return optionsHtml;
    }

    function renderQuiz(quiz, questionNumber) {
        var html = `
            <div class="num">Q.${questionNumber}</div>
            <div class="question">${quiz.question}</div>
            <div class="options">
                ${renderOptions(quiz)}
            </div>
            <div class="quiz__side">
                <div class="quiz__bar"></div>
                <div class="quiz__count">${questionNumber}/10</div>
            </div>
            <div class="quiz__result">결과확인</div>
        `;

        $('.quiz__contants.q2').html(html);

        $('.op').each(function(index, option) {
            $(option).click(function() {
                userAnswers[questionNumber - 1] = $(option).text();
                if ($(option).text() === quiz.correct_answer) {
                    $(option).addClass('correct');
                    correctCount++;
                } else {
                    $(option).addClass('incorrect');
                }

                setTimeout(function() {
                    if (questionNumber >= 10) {
                        $('.quiz__result').addClass('show');
                    } else {
                        currentQuestionIndex++;
                        loadQuiz(currentQuestionIndex);
                        var progressPercent = ((currentQuestionIndex + 1) / 10) * 100;
                        document.querySelector('.quiz__side').style.setProperty('--progress-height', progressPercent + '%');
                    }
                }, 1000);
            });
        });

        $('.quiz__result').click(function() {
            var resultPage = $('.quiz__contants.q3');
            var quizPage = $('.quiz__contants.q2');

            var score = correctCount;
            var rank;
            if (score >= 8) {
                rank = "당신은 분리배출 만렙박사";
            } else if (score >= 5) {
                rank = "당신은 분리배출 상식러";
            } else {
                rank = "당신은 분리배출 새싹";
            }

            resultPage.html(`
                <h2>총 10문제 중 <i>${score}</i> 문제를 맞히셨습니다.</h2>
                <div class="rank">
                    <h3>${rank}</h3>
                </div>
                <div class="desc">설명보러가기</div>
            `);

            resultPage.data('quiz', quiz);
            resultPage.data('userAnswer', userAnswers[currentQuestionIndex]);

            quizPage.hide();
            resultPage.show();

            $('.quiz__contants.q3').on('click', '.desc', function() {
                var resultPage = $('.quiz__contants.q3');
                var descPage = $('.quiz__contants.q4');

                var allQuizDesc = quizData.map(function(quiz, index) {
                    var descHtml = quiz.desc.map(function(desc) {
                        return `<p>${desc}</p>`;
                    }).join('');

                    return `
                        <div class="desc__wrap">
                            <div class="question">문제 ${index + 1} : ${quiz.question}</div>
                            <div class="useranswer">선택한 답 : ${userAnswers[index]}</div>
                            <div class="correctanswer">정답 : ${quiz.correct_answer}</div>
                            <div class="desc2">해설 : ${descHtml}</div>
                        </div>
                    `;
                }).join('');

                descPage.html(allQuizDesc);

                resultPage.hide();
                descPage.show();
            });
        });
    }
});
</script>