<?php
include "../connect/connect.php";
include "../connect/session.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $youId = mysqli_real_escape_string($connect, $_POST['youId']);
    $youName = mysqli_real_escape_string($connect, $_POST['youName']);
    $youPhone = mysqli_real_escape_string($connect, $_POST['youPhone']);

    $sql = "SELECT * FROM teamMembers WHERE youId = '$youId' AND youName = '$youName' AND youPhone = '$youPhone'";

    $result = $connect->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $foundPass = $row['youPass'];
    } else {
        echo "<script>
                alert('일치하는 정보가 없습니다.');
                location.href = 'joinId.php';
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<?php include "../include/head.php" ?>

</head>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main">
        <div class="login__inner container">
            <div class="login__wrap">
                <div class="login__box">
                    <h2>비밀번호 찾기 성공</h2>
                    <div class="login__idbox">
                        <div class="login__findid">당신의 비밀번호는 ' <em><?=$foundPass?></em> ' 입니다.</div>
                        <img src="../../assets/img/findcom.gif" alt="findcomimg">
                        <button class="login__btn2 btn__style1"><a href="../login/login.php">로그인 하기</a></button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

</body>

</html>