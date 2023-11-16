<?php
include "../connect/connect.php";
include "../connect/session.php";

?>

<!DOCTYPE html>
<html lang="ko">
<?php include "../include/head.php" ?>
<style>
    #header {
        background-color: #fff0;
    }
</style>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main">
        <div class="slider">
            <div class="slider__slide slider__slide--active" data-slide="1">
                <div class="slider__wrap">
                    <div class="slider__back"></div>
                </div>
                <div class="slider__inner">
                    <div class="slider__content">
                        <h1>환경을 <br> 생각하고</h1><a class="go-to-next">next</a><br>
                        <div class="pauseButton"></div>
                        <div class="resumeButton"></div>
                    </div>
                </div>
            </div>
            <div class="slider__slide" data-slide="2">
                <div class="slider__wrap">
                    <div class="slider__back"></div>
                </div>
                <div class="slider__inner">
                    <div class="slider__content">
                        <h1>지구를 <br> 살리고</h1><a class="go-to-next">next</a><br>
                        <div class="pauseButton"></div>
                        <div class="resumeButton"></div>
                    </div>
                </div>
            </div>
            <div class="slider__slide" data-slide="3">
                <div class="slider__wrap">
                    <div class="slider__back"></div>
                </div>
                <div class="slider__inner">
                    <div class="slider__content">
                        <h1>더나은 <br> 미래를 만든다</h1><a class="go-to-next">next</a><br>
                        <div class="pauseButton"></div>
                        <div class="resumeButton"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="quiz__inner" id="quizSection">
            <div class="quiz__container">
                <div class="quiz__wrap">
                    <div class="quiz__title">Quiz</div>
                    <div class="quiz__contants q1">
                        <h1>
                            분리배출<br>
                            어디까지 알고 있니?
                        </h1>
                        <ul>
                            <li><img src="../../assets/img/quizimg01.png" alt="퀴즈이미지"></li>
                            <li><img src="../../assets/img/quizimg02.png" alt="퀴즈이미지"></li>
                            <li><img src="../../assets/img/quizimg03.png" alt="퀴즈이미지"></li>
                            <li><img src="../../assets/img/quizimg04.png" alt="퀴즈이미지"></li>
                        </ul>
                        <div class="quiz__btn">테스트 하러가기</div>
                    </div>
                    <div class="quiz__contants q2"></div>
                    <div class="quiz__contants q3"></div>
                    <div class="quiz__contants q4"></div>
                </div>
            </div>
        </div>

        <div class="intro__inner">
            <div class="introWrap">
                <div class="intro__text">
                    <h3>이번주 BEST 이슈</h3>
                    <p>이번주 가장 인기 있는 품목을 모아보아요.</p>
                </div>
                <section class="hero-section container">
                    <div class="card-grid">
                        <a class="card" href="../subboard/submain.php">
                            <div class="card__background"
                                style="background-image: url(../../assets/img/intro__inner01.jpg)"></div>
                            <div class="card__content">
                                <p class="card__category">Category</p>
                                <h3 class="card__heading">대형가구</h3>
                            </div>
                        </a>
                        <a class="card" href="../subboard/submain.php">
                            <div class="card__background"
                                style="background-image: url(../../assets/img/intro__inner02.jpg)"></div>
                            <div class="card__content">
                                <p class="card__category">Category</p>
                                <h3 class="card__heading">중형가구</h3>
                            </div>
                        </a>
                        <a class="card" href="../subboard/submain.php">
                            <div class="card__background"
                                style="background-image: url(../../assets/img/intro__inner03.jpg)"></div>
                            <div class="card__content">
                                <p class="card__category">Category</p>
                                <h3 class="card__heading">중형가구</h3>
                            </div>
                        </a>
                        <a class="card" href="../subboard/submain.php">
                            <div class="card__background"
                                style="background-image: url(../../assets/img/intro__inner04.jpg)"></div>
                            <div class="card__content">
                                <p class="card__category">Category</p>
                                <h3 class="card__heading">소형가구</h3>
                            </div>
                        </a>
                        <div>
                </section>
            </div>
        </div>

        <div class="category__inner">
            <div class="category__wrap">
                <div class="category__left">
                    <div class="category__iframe">
                        <iframe src="https://www.youtube.com/embed/ruT5TZZidOg?si=JgyoPN_uuiOLLSV9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <a href="../subboard/submain.php"><span>분리배출 방법을 모르겠다면</span></a>
                </div>
                <div class="category__right">
                    <h1>카테고리별 쓰레기</h1>
                    <div class="img__wrap">
                        <div class="imgslider" id="imgSlider1">
                            <ul>
                                <li><img src="../../assets/img/fashion01.jpg" alt=""></li>
                                <li><img src="../../assets/img/furniture1.jpg" alt=""></li>
                                <li><img src="../../assets/img/plastic01.jpg" alt=""></li>
                                <li><img src="../../assets/img/desk.jpg" alt=""></li>
                                <li><img src="../../assets/img/jewelry.jpg" alt=""></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <?php include "../include/mainjs.php" ?>
    <!-- //script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
            
    // 영역내 마우스휠
    $.fn.extend({
        mouse_wheel: function() {
            $(this).on('mousewheel', function(e) {
                if (e.originalEvent.wheelDelta >= 120) {
                    this.scrollTop -= 50;
                } else if (e.originalEvent.wheelDelta <= -120) {
                    this.scrollTop += 50;
                }
                return false;
            });
        }
    });

    $('.quiz__contants.q4').mouse_wheel();
    </script>
</body>

</html>