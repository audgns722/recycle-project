<?php
include "../connect/connect.php";
include "../connect/session.php";

$memberId = $_SESSION['memberId'];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- 아이콘 -->
    <link rel="stylesheet" href="https://fontawesome.com/icons/bullhorn?f=classic&s=solid">

</head>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->


    <!-- main -->
    <main id="main">
        <div class="board__title">
            <h1>Board</h1>
        </div>
        <section class="board__inner">
            <div class="board__nav">
                <ul>
                    <li><a href="boardCate.php?category=공지사항">공지사항</a></li>
                    <li><a href="boardCate.php?category=질문하기">질문하기</a></li>
                    <li><a href="boardCate.php?category=문의하기">1:1문의</a></li>
                </ul>
            </div>

            <div class="board__write container">
                <form action="boardWriteSave.php" name="boardWriteSave" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="boardCategory" class="blind">카테고리</label>
                        <select name="boardCategory" id="boardCategory">
                            <option value="질문하기">질문하기</option>
                            <option value="문의하기">문의하기</option>
<?php 
    if ($memberId < 9999) {
        echo '<option value="공지사항">공지사항</option>';
    } else {
        echo '<option value="공지사항" class="hidden">공지사항</option>';
    }
?>
                            
                        </select>
                    </div>
                    <table class="write__table">
                        <tr>
                            <td>제목</td>
                            <td><input type="text" id="boardTitle" name="boardTitle"></td>
                        </tr>
                        <tr>
                            <td>내용</td>
                            <td><textarea name="boardContents" id="boardContents" rows="20"></textarea></td>
                        </tr>
                    </table>
                    <div class="file">
                        <!-- accept=".jpg, .jpeg, .png, .gif, .webp" -->
                        <label for="boardFile" class="blind">파일</label>
                        <input type="file" id="boardFile" name="boardFile">
                        <p>* jpg, jpeg, gif, png, webp 파일만 넣을 수 있습니다. 이미지 용량은 1MB를 넘길 수 없습니다.</p>
                    </div>
                    <div class="board__btns">
                        <a href="board.php" class="write__btn2 btn__style1">취소하기</a>
                        <button type="submit" class="write__btn btn__style1">저장하기</button>
                    </div>
                </form>
            </div>
        </section>
    </main>


    <!-- footer -->
    <?php include "../include/footer.php" ?>
</body>

</html>