<?php
include "../connect/connect.php";
include "../connect/session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_SESSION['memberId'];

    // 사용자 데이터 업데이트 (youDelete 값을 1로 변경)
    $updateUserSql = "UPDATE teamMembers SET youDelete = 2 WHERE memberId = $memberId";
    $result = $connect->query($updateUserSql);

    if ($result) {
        echo "<script>alert('회원 탈퇴가 되셨습니다.')</script>";
        unset($_SESSION['memberId']);
        unset($_SESSION['youId']);
        unset($_SESSION['youName']);
    } else {
        echo "<script>alert('회원 탈퇴에 실패했습니다.')</script>";
        echo '<script>window.history.back();</script>';
    } 
} else {
    echo "<script>alert('회원 탈퇴에 실패했습니다.')</script>";
    echo '<script>window.history.back();</script>';
}
?>