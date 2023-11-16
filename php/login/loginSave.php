<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?> 

<!DOCTYPE html>
<html lang="ko">
<?php include "../include/head.php" ?>
<style>
    .login__box p {
        font-size: 29px;
        line-height: 1.5;
    }
</style>
​
<body>
<?php include "../include/header.php" ?>

    <main id="main">
        <div class="login__inner container">
            <div class="login__wrap">
                <div class="login__box">
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $youId = $_POST['youId'];
    $youPass = $_POST['youPass'];

    // 메세지 출력
    function msg($alert)
    {
        echo "<p>$alert</p>";
    }

    // 데이터 조회
    $sql = "SELECT memberId, youName, youPass, youDelete FROM teamMembers WHERE youId = '$youId' AND youPass = '$youPass'";
    $result = $connect->query($sql);

    if ($result) {
        $count = $result->num_rows;

        if ($count == 0) {
            msg("이메일 또는 비밀번호가 틀렸거나 회원이 아니십니다.<br />다시 한번 확인해주세요!");
        } else {
            $memberInfo = $result->fetch_array(MYSQLI_ASSOC);

            if ($memberInfo['youDelete'] == 2) {
                // 회원 탈퇴 상태
                msg("이미 탈퇴한 계정입니다.<br />다시 가입하려면 회원 가입을 진행해주세요!");
            } elseif ($memberInfo['youDelete'] == 1) {
                // 정상 로그인 처리
                $_SESSION['memberId'] = $memberInfo['memberId'];
                $_SESSION['youName'] = $memberInfo['youName'];
                echo '<script>window.location.href = "../main/main.php"</script>';
            } elseif ($memberInfo['youDelete'] == 0) {
                // 회원 가입 필요
                msg("가입된 계정이 아닙니다.<br />회원 가입을 진행해주세요!");
            }
        }
    }
}
?> 
                    <button class="login__btn2 btn__style1">로  그  인</button>
                </div>
            </div>
        </div>
    </main>
    
    
    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>
</html>