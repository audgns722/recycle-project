<?php
include "../connect/connect.php";
include "../connect/session.php";

if (isset($_GET['boardId'])) {
    $boardId = $_GET['boardId'];

    // 게시물 정보 가져오기
    $sql = "SELECT * FROM teamBoard WHERE boardId = {$boardId}";
    $result = $connect->query($sql);

    if ($result) {
        $info = $result->fetch_array(MYSQLI_ASSOC);
        
        // 현재 로그인한 사용자와 게시물 작성자를 비교
        if ($info['memberId'] == $_SESSION['memberId']) {
            // 사용자 인증 확인: 게시물 작성자와 수정 요청자가 일치
            // 수정 페이지를 표시하거나 수정을 허용할 수 있습니다.
        } else {
            // 사용자 인증 실패: 게시물 작성자와 수정 요청자가 다름
            echo "<script>alert('수정 권한이 없습니다.');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        echo "게시글을 가져올 수 없습니다.";
    }
} else {
    // boardId를 받지 못한 경우 처리
    echo "게시물 ID가 누락되었습니다.";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "../include/head.php" ?>
</head>


<body>
   <?php include "../include/header.php" ?>
    <!-- //header -->

    <!-- main -->
    <main id="main">
        <div class="board__title">
            <h1>수정하기</h1>
        </div>
        <section class="board__inner">
            <div class="board__write container">
                <form action="boardModifySave.php" name="boardModifySave" method="post" enctype="multipart/form-data">
                    <table class="write__table">
                        <tr>
                            <td>제목</td>
                            <td>
                                <input type="text" id="boardTitle" name="boardTitle" value="<?=$info['boardTitle']?>">
                            </td>
                        </tr>
                        <tr>
                            <td>내용</td>
                            <td>
                                <textarea name="boardContents" id="boardContents" rows="20"><?=$info['boardContents']?></textarea>
                            </td>
                        </tr>
                    </table>
                    <div style="display: none">
                        <label for="boardId">번호</label>
                        <input type="text" id="boardId" name="boardId" value="<?=$info['boardId']?>">
                    </div>
                    <div class="file">
                        <!-- accept=".jpg, .jpeg, .png, .gif, .webp" -->
                        <label for="boardFile" class="blind">파일</label>
                        <input type="file" id="boardFile" name="boardFile">
                        <p>* jpg, gif, png, webp 파일만 넣을 수 있습니다. 이미지 용량은 1MB를 넘길 수 없습니다.</p>
                    </div>

                    <div class="board__btns">
                        <a href="../board/boardCate.php?category=질문하기" class="write__btn btn__style1" style="line-height : 3; width : 95px; text-align: center;">취소</a>
                        <button type="submit" class="write__btn btn__style1">수정하기</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>