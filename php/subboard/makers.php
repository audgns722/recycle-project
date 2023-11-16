<?php 
    include "../connect/connect.php";
    include "../connect/session.php";
?>
<!DOCTYPE html>
<html lang="ko">
<?php include "../include/head.php" ?>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main" role="main">
        <section id="makeWrap">
            <div class="make__inner container">
                <div class="make__text">
                    <h3>만든사람들</h3>
                </div>
                <div class="makemain">
                    <img src="../../assets/img/make.jpg" alt="">
                    <div class="text">
                        <div class="text1">
                            <h4>분리배출이란?</h4>
                            <p>폐기물의 소각 및 재활용 등 처분을 용이하게 하기 위해, 그 재질마다 폐기물을 분류하고 그것을 수집하는 것을 말한다.
                                '수거'는 지자체나 혹은 그곳과 계약된 수거 업체가 하는 것이고, 일상에서는 '배출'만을 하게 된다.
                                수거자가 아닌 배출자가 기준인 분리배출로 되어 있다. 항목명이나 평소에 이를 일컫는 용어도 사실은 분리배출이 맞다.
                                더 정확히 하면 분류배출이지만 정책명도 그렇고 분리배출이라고 쓴다.
                            </p>
                        </div>
                        <div class="text1">
                            <h4>분리배출요령</h4>
                            <p>분리배출을 할 때는 가능한한 종류별로 섞이지 않게 모아서 배출해야 한다.
                                이상적인 분리배출은 재료에 따라서 모든 종류를 세부적으로 나눠 배출하는 것이지만, 현실적으로 불가능하다.
                                일반 가정에서는 대분류로 종이/유리/캔/페트/플라스틱/비닐 별로 모아서 배출하면 재활용업체가 수거해가서
                                추가적인 소분류를 하는 방식으로 이루어진다.
                            </p>
                        </div>
                        <div class="end">
                            <h4>만든사람들</h4>
                            <p>
                            이명훈, 김희진
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--// sliderWrap -->
    </main>
    <!--// main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <?php include "../include/mainjs.php" ?>
    <!-- //script -->

</body>

</html>