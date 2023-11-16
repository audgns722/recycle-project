<?php
include "../connect/connect.php";
include "../connect/session.php";
// 비밀번호 변경하기
if (isset($_SESSION['memberId'])) {
    $memberId = $_SESSION['memberId'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // 현재 비밀번호가 맞는지 확인

    $checkPasswordSql = "SELECT * FROM teamMembers WHERE memberId = $memberId AND youPass = '$currentPassword'";
    $checkPasswordResult = $connect->query($checkPasswordSql);

    if ($checkPasswordResult->num_rows > 0) {
        // 현재 비밀번호가 맞는 경우, 새 비밀번호로 업데이트

        $updatePasswordSql = "UPDATE teamMembers SET youPass = '$newPassword' WHERE memberId = $memberId";
        $updatePasswordResult = $connect->query($updatePasswordSql);

        if ($updatePasswordResult) {
            echo "<script>alert('비밀번호변경에 성공하셨습니다.')</script>";
            echo "<script>window.history.back();</script>";
        } else {
            echo "error"; // 비밀번호 변경 실패
        }
    } else {
        echo "<script>alert('현재 비밀번호와 일치하지 않습니다.')</script>";
        echo "<script>window.history.back();</script>";
    }
} else {
    echo "not_logged_in"; // 로그인되지 않은 경우
}

?>