<!DOCTYPE html>
<html lang="ko">

<head>
<?php include "../include/head.php" ?>

    <style>
        .images__wrap span {
            background-image: url(../../assets/img/idfindimg.png);
        }
    </style>
</head>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main">
        <div class="login__inner container">
            <div class="login__wrap">
                <div class="login__box">
                    <h2>비밀번호찾기</h2>
                    <h3>아이디가 기억나지 않는다면?<a href="joinId.php" class="joinbtn">아이디 찾기</a></h3>
                    <form action="passfindcom.php" name="passfindcom" method="post" class="login__form">
                        <div class="join__id">
                            <h4>아이디</h4>
                            <label for="youId">
                                <input class="joinid__input" type="text" id="youId" name="youId" placeholder="아이디">
                            </label>
                        </div>
                        <div class="join__id">
                            <h4>이름</h4>
                            <label for="youName">
                                <input class="joinid__input" type="text" id="youName" name="youName" placeholder="이름">
                            </label>
                        </div>
                        <div class="join__id">
                            <h4>휴대폰 번호</h4>
                            <label for="youPhone">
                                <input class="joinid__input" type="text" id="youPhone" name="youPhone" placeholder="휴대폰번호">
                            </label>
                        </div>
                        
                        <button class="login__btn2 btn__style1" type="submit">비 밀 번 호 찾 기</button>

                    </form>
                </div>
            </div>
        </div>
    </main>



    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>

</html>