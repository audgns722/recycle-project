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
                    <h2>아이디찾기</h2>
                    <h3>비밀번호가 기억나지 않는다면?<a href="joinpass.php" class="joinbtn">비밀번호 찾기</a></h3>
                    <form action="idfindcom.php" name="idfindcom" method="post" class="login__form">
                        <div class="join__id">
                            <h4>이름</h4>
                            <label for="youName">
                                <input class="joinid__input"type="text" id="youName" name="youName">
                            </label>
                        </div>
                        <div class="join__id">
                            <h4>휴대폰 번호</h4>
                            <label for="youPhone">
                                <input class="joinid__input"type="text" id="youPhone" name="youPhone">
                            </label>
                        </div>
                        <button class="login__btn2 btn__style1" type="submit">아 이 디 찾 기</button>                        
                    </form>
                </div>
            </div>
        </div>
    </main>

    
    
    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>
</html>