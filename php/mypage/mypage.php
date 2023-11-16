<?php
include "../connect/connect.php";
include "../connect/session.php";

if (!isset($_SESSION['memberId'])) {
    echo "<script>alert('로그인을 해주세요');</script>";
    echo '<script>window.location.href = "../login/login.php";</script>';
}

// 현재 로그인한 사용자의 ID를 가져옴
if (isset($_SESSION['memberId'])) {
    $memberId = $_SESSION['memberId'];
} else {
    $memberId = 0; // 로그인되지 않은 경우, 예를 들어 0으로 설정
}

// 사용자 정보를 데이터베이스에서 가져옴
$userInfoSql = "SELECT * FROM teamMembers WHERE memberId = $memberId";
$userInfoResult = $connect->query($userInfoSql);
$userInfo = $userInfoResult->fetch_assoc();

$youName = $userInfo['youName'];

// 사용자 프로필 이미지 표시
if ($userInfo['youImgSrc'] != "") {
    $profileImagePath = $userInfo['youImgSrc'];
} else {
    $profileImagePath = "../../assets/mypage/Img_default.jpg"; // 디폴트 이미지 경로
}

// 게시판 정보를 가져옴
$userWritesSql = "SELECT * FROM teamBoard WHERE memberId = $memberId"; // 해당 유저가 작성한 글을 가져오는 쿼리
$userWritesResult = $connect->query($userWritesSql);
?>

<!DOCTYPE html>
<html lang="ko">
<style>

</style>
<?php include "../include/head.php" ?>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('previewImage').src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->


    <!-- main -->
    <main id="main">
        <div class="board__title2">
        </div>
        <section class="board__inner2">
            <div class="mypage__inner">
                <div class="mytable1">
                    <h3>마이페이지</h3>
                    <div class="pro">
                        <img src="<?= $profileImagePath ?>" alt="프로필이미지">
                        <h1>
                            <?= $youName ?> 님
                        </h1>
                    </div>
                    <div class="list_box">
                        <div class="my_list">
                            <div class="button">
                                <h2>내작성글</h2>
                            </div>
                            <div class="sub_button">
                                <p class="popup_button">
                                    <a href="#" class="popup-btn1">📃 내작성글 보기</a>
                                </p>
                            </div>
                        </div>
                        <div class="my_list">
                            <div class="button">
                                <h2>내 정보수정</h2>
                            </div>
                            <div class="sub_button">
                                <p>
                                    <a href="#" class="popup-btn2">🔒 비밀번호 변경</a>
                                </p>
                                <p>
                                    <a href="#" class="popup-btn3">📸 프로필사진 변경</a>
                                </p>
                            </div>
                        </div>
                        <div class="my_list">
                            <div class="button">
                                <h2>회원탈퇴</h2>
                            </div>
                            <div class="sub_button">
                                <p><a href="#" class="popup-btn4">🔧 탈퇴하기</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 내 작성글 부분 -->
    <div class="popup-view1 viewReal">
        <div class="home">
            <h3>
                <?= $youName ?> 님이 작성한 글
            </h3>
            <div class="list">
                <ul>
                    <?php
                    while ($row = $userWritesResult->fetch_assoc()) {
                        $boardId = $row['boardId'];
                        $boardTitle = $row['boardTitle'];
                        $boardDate = $row['regTime']; // 이 필드는 데이터베이스에서 가져오는 필드 이름에 맞게 수정해야 합니다.
                    
                        // 작성일 포맷 변경 (예: Y-m-d H:i:s)
                        $formattedDate = date("Y-m-d", $boardDate);

                        echo '<li><a href="../board/boardView.php?boardId=' . $boardId . '">💬 ';
                        echo $boardTitle;
                        echo '</a> ' . $formattedDate . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="button">
                <a href="#" class="popup-close">닫기</a>
            </div>
        </div>

    </div>


    <!-- 비밀번호 변경 -->
    <form id="changePasswordForm" method="POST" action="changePassword.php">
        <div class="popup-view2 viewReal">
            <div class="home">
                <h3>비밀번호 변경</h3>
                <div class="input_pass">
                    <label for="currentPassword">현재 비밀번호</label>
                    <input type="password" name="currentPassword" id="currentPassword">
                    <label for="newPassword">새 비밀번호</label>
                    <input type="password" name="newPassword" id="newPassword">
                </div>
                <div class="button">
                    <button type="submit" class="popup-modify" id="changePasswordBtn">변경</button>
                    <a href="#" class="popup-close">닫기</a>
                </div>
            </div>
        </div>
    </form>

    <!-- 탈퇴 확인 팝업 -->
    <div class="popup-view3 viewReal">
        <div class="home">
            <h3>회원탈퇴</h3>
            <div class="out__img"></div>
            <div class="out">
                <h2>
                    <?= $youName ?> 님 정말 <em>탈퇴</em> 하시겠습니까?
                </h2>
            </div>
            <div class="button">
                <a href="#" class="popup-modify" id="confirmDelete">확인</a>
                <a href="#" class="popup-close">닫기</a>
            </div>
        </div>
    </div>

    <div class="popup-view4 viewReal">
        <div class="home">
            <h3>프로필사진 변경</h3>
            <div class="changeImg">
                <img id="previewImage" src="<?= $profileImagePath ?>" alt="프로필 이미지">
            </div>
            <div class="file">
                <form id="profileImageForm" method="POST" enctype="multipart/form-data" action="uploadProfileImage.php">
                    <label for="mypageFile" class="blind">파일</label>
                    <input type="file" id="mypageFile" name="mypageFile" accept="image/*" onchange="previewImage(this)">
                    <p>jpg, gif, webp, png 파일만 넣을 수 있습니다.<br> 이미지 용량은 1MB를 넘길 수 없습니다.</p>
                    <div class="button">
                        <button type="submit" class="popup-modify">확인</button>
                        <a href="#" class="popup-close">닫기</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>

    <!-- footer -->
    <?php include "../include/footer.php" ?>


    <script>
        $(function () {
            // 팝업 1
            $(".popup-btn1").click(function () {
                $(".popup-view1").show();
            });
            $(".popup-close").click(function () {
                $(".popup-view1").hide();
            });



            $("#changePasswordBtn").on("click", function () {
                $("#changePasswordForm").submit();
            });
            // 비밀번호 변경
            $(function () {
                // 팝업 2
                $(".popup-btn2").click(function () {
                    $(".popup-view2").show();
                });
                $(".popup-close").click(function () {
                    $(".popup-view2").hide();
                });

                // 비밀번호 변경 버튼 클릭 시
                $("#changePasswordBtn").click(function () {
                    var currentPassword = $("#currentPassword").val();
                    var newPassword = $("#newPassword").val();

                    // AJAX 요청을 사용하여 서버로 현재 비밀번호와 새 비밀번호를 전송
                    $.ajax({
                        type: "POST",
                        url: "changePassword.php", // 비밀번호 변경을 처리할 서버 스크립트 파일
                        data: {
                            currentPassword: currentPassword,
                            newPassword: newPassword
                        },
                        success: function (response) {
                            // 서버에서 비밀번호 변경 성공 또는 실패 여부를 반환한 경우 처리
                            if (response === "success") {
                                alert("비밀번호가 성공적으로 변경되었습니다.");
                                $(".popup-view2").hide();
                            } else {
                                alert("비밀번호 변경에 실패했습니다. 다시 시도하세요.");
                            }
                        }
                    });
                });
            });

            // 팝업 3
            $(".popup-btn4").click(function () {
                $(".popup-view3").show();
            });
            $(".popup-close").click(function () {
                $(".popup-view3").hide();
            });
            // 회원탈퇴
            $("#confirmDelete").on("click", function () {
                $.ajax({
                    type: "POST",
                    url: "deleteAccount.php",
                    success: function (response) {
                        if (response.includes("회원 탈퇴가 되셨습니다.")) {
                            alert("회원 탈퇴가 완료되었습니다.");
                            window.location.href = "../login/logout.php";
                        } else {
                            alert("회원 탈퇴에 실패했습니다. 다시 시도하세요.");
                        }
                    }
                });
            });

            // 팝업 4
            $(".popup-btn3").click(function () {
                $(".popup-view4").show();
            });
            $(".popup-close").click(function () {
                $(".popup-view4").hide();
            });


        });

    </script>
</body>

</html>