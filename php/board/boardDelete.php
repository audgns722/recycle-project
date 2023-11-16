<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    $boardId = $_GET['boardId'];
    $memberId = $_SESSION['memberId'];

    // 게시글 소유자 확인
    $sql = "SELECT * FROM teamBoard WHERE boardId = {$boardId}";
    $result = $connect -> query($sql);

    if($result) {
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        $boardOwnerId = $info['memberId'];

        // 로그인 ID 게시글 ID 일치하는지 확인
        if($memberId == $boardOwnerId) {
            $sql = "DELETE FROM teamBoard WHERE boardId = {$boardId}";
            $connect -> query($sql);
            echo "<script>alert('게시글이 삭제되었습니다.'); </script>";
            echo "<script>window.location.href = 'board.php' </script>";
        } else {
            echo "<script>alert('게시글 소유자만 삭제 할 수 있습니다.'); </script>";
            echo "<script>window.history.back(); </script>";
        }
    } else {
        echo "<script>alert('관리자에게 문의해주세요!'); window.history.back()</script>";
    }
?>