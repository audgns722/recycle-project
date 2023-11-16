<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    
    // 댓글 쓰기 버튼 클릭 시 실행되는 스크립트
    if (!isset($_SESSION['memberId'])) {
        // 사용자가 로그인되어 있지 않은 경우
        echo "<script>alert('로그인을 해주세요');</script>";
        echo '<script>window.location.href = "../login/login.php";</script>';
    } else {
        $memberId = $_POST['memberId'];
        $boardId = $_POST['boardId'];
        $commentName = $_POST['name'];
        $commentPass = $_POST['pass'];
        $commentWrite = $_POST['msg'];
        $regTime = time();
    
        // 프로필 이미지 가져오기
        $profileImageSql = "SELECT youImgSrc FROM teamMembers WHERE memberId = '$memberId'";
        $profileImageResult = $connect->query($profileImageSql);
        $profileImage = "";
        if ($profileImageResult->num_rows > 0) {
            $profileImageData = $profileImageResult->fetch_assoc();
            $profileImage = $profileImageData['youImgSrc'];
        }
    
        $sql = "INSERT INTO boardComment(memberId, boardId, commentName, commentPass, commentMsg, commentDelete, regTime, profileImage) VALUES('$memberId', '$boardId', '$commentName', '$commentPass', '$commentWrite', '1', '$regTime', '$profileImage')";
        $result = $connect->query($sql);
    
        echo json_encode(array("info" => $boardId));
    }
?>
