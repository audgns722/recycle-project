<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?> 

<!DOCTYPE html>
<html lang="ko">
<?php include "../include/head.php" ?>
<body>
<?php include "../include/header.php" ?>

    <main id="main">
        <div class="login__inner">
            <div class="login__wrap">
                <div class="login__box">
                    <h2>로 그 인</h2>
                    <h3>아직 회원이 아니십니까?<a href="../join/joinAgree.php" class="joinbtn">회원가입</a></h3>
                    <form action="loginSave.php" name="loginSave" method="post" class="login__form">
                        <label for="youId">
                            아이디<input class="login__id"type="text" id="youId" name="youId">
                        </label>
                        <label for="youPass">
                            비밀번호<input type="password" id="youPass" name="youPass">
                        </label>
                        <div class="login__find">
                            <a href="../join/joinId.php">아이디 찾기</a>
                            <a href="../join/joinpass.php">비밀번호 찾기</a>
                        </div>
                        <button class="login__btn2">로그인 하기</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>