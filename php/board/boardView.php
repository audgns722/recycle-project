<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if (isset($_SESSION['memberId'])) {
        $memberId = $_SESSION['memberId'];
    } else {
        $memberId = 0;
    }

    if (isset($_GET['boardId'])) {
        $boardId = $_GET['boardId'];
    } else {
        Header("Location: board.php");
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
        $profileImagePath = "Img_default.jpg"; // 디폴트 이미지 경로
    }
        $commentSql = "SELECT c.*, m.youImgSrc 
               FROM boardComment AS c 
               LEFT JOIN teamMembers AS m ON c.memberId = m.memberId 
               WHERE c.boardId = '$boardId' AND c.commentDelete = '1' 
               ORDER BY c.commentId ASC";


    // 조회수 추가
    $updateViewSql = "UPDATE teamBoard SET boardView = boardView + 1 WHERE boardId = '$boardId'";
    $connect->query($updateViewSql);

    // 블로그 정보 가져오기
    $teamBoardSql = "SELECT * FROM teamBoard WHERE boardId = '$boardId'";
    $teamBoardResult = $connect->query($teamBoardSql);
    $teamBoardInfo = $teamBoardResult->fetch_array(MYSQLI_ASSOC);

    // 이전글 가져오기
    $prevteamBoardSql = "SELECT * FROM teamBoard WHERE boardId < '$boardId' ORDER BY boardId DESC LIMIT 1";
    $prevteamBoardResult = $connect->query($prevteamBoardSql);
    $prevteamBoardInfo = $prevteamBoardResult->fetch_array(MYSQLI_ASSOC);

    // 다음글 가져오기
    $nextteamBoardSql = "SELECT * FROM teamBoard WHERE boardId > '$boardId' ORDER BY boardId ASC LIMIT 1";
    $nextteamBoardResult = $connect->query($nextteamBoardSql);
    $nextteamBoardInfo = $nextteamBoardResult->fetch_array(MYSQLI_ASSOC);

    // 댓글 정보 가져오기
    $commentSql = "SELECT bc.*, m. youName 
                FROM boardComment bc 
                JOIN teamMembers m ON bc.memberId = m.memberId 
                WHERE bc.boardId = '$boardId' AND bc.commentDelete = '1' 
                ORDER BY bc.commentId ASC";
    $commentResult = $connect->query($commentSql);
    $commentInfo = $commentResult->fetch_array(MYSQLI_ASSOC);

    // 사용자가 선택한 좋아요/싫어요를 가져옴
    $likeSql = "SELECT likeAction FROM teamLikes WHERE memberId = '$memberId' AND boardId = '$boardId'";
    $likeResult = $connect->query($likeSql);
    $likeData = $likeResult->fetch_assoc();

    $likeClass = '';
    $dislikeClass = '';
    if ($likeData['likeAction'] === 'like') {
        $likeClass = 'selected';
    } elseif ($likeData['likeAction'] === 'dislike') {
        $dislikeClass = 'selected2';
    }

    $countSql = "SELECT boardLike, boardDislike FROM teamBoard WHERE boardId = '$boardId'";
    $countResult = $connect->query($countSql);
    $countData = $countResult->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include "../include/head.php" ?>

    <?php include "../include/boardviewcss.php" ?>
</head>

<body>
    <?php include "../include/header.php" ?>

    <!-- main -->
    <main id="main">
        <section class="board__inner container">
            <div class="board__nav">
                <ul>
                    <li><a href="boardCate.php?category=공지사항">공지사항</a></li>
                    <li><a href="boardCate.php?category=질문하기">질문하기</a></li>
                    <li><a href="boardCate.php?category=문의하기">문의하기</a></li>
                </ul>
            </div>
            <section class="board__view">
                <h3>제목 : <?=$teamBoardInfo['boardTitle']?></h3>
                <div class="info">
                    <span class="author">작성자 : <?=$teamBoardInfo['boardAuthor']?></span>
                    <span class="date">작성일자 : <?=date('Y-m-d', $teamBoardInfo['regTime'])?></span>
                </div>
                <div class="contents">
                    <span><?=$teamBoardInfo['boardContents']?></span>
                    <div class="img__box">
<?php
    $imagePath = "../../assets/board/" . $teamBoardInfo['boardImgFile'];
    $altText = !empty($teamBoardInfo['boardImgFile']) ? $teamBoardInfo['boardTitle'] : '';
    echo '<img src="' . $imagePath . '" alt="' . $altText . '" onclick="openImage(this.src, this.alt)">';
?>
                    <p>이미지를 클릭하시면 확대됩니다.</p>
                    </div>
                </div>
            </section>

            <section class="blog__index">
                <h4 class="blind">이전글/다음글 가기</h4>

<?php if(!empty($prevteamBoardInfo)) { ?>
    <a href="boardView.php?boardId=<?=$prevteamBoardInfo['boardId']?>" class="prev">
    이전글 <?=substr($prevteamBoardInfo['boardTitle'], 0, 20);?>...
</a>
<?php } else { ?>
    <span class="prev">이전 글이 없습니다.</span>
<?php } ?>

<?php if(!empty($nextteamBoardInfo)) { ?>
    <a href="boardView.php?boardId=<?=$nextteamBoardInfo['boardId']?>" class="next">
    다음글 <?=substr($nextteamBoardInfo['boardTitle'], 0, 20);?>...
</a>
<?php } else { ?>
    <span class="next">다음 글이 없습니다.</span>
<?php } ?>
            </section>

            <!-- 좋아요 싫어요 -->
            <section id="blogLike">
                    <div class="like__box">
                        <button id="likeButton" data-action="like" class="like <?=$likeClass?>"></button>
                        <p>좋아요: <span id="likeCount"><?=$countData['boardLike']?></span></p>
                        <button id="dislikeButton" data-action="dislike" class="dislike <?=$dislikeClass?>"></button>
                        <p>싫어요: <span id="dislikeCount"><?=$countData['boardDislike']?></span></p>
                    </div>
                    <div class="board__btns">
                        <button id="editButton" class="write__btn btn__style1" onclick="confirmEdit()">수정하기</button>
                        <button id="deleteButton" class="write__btn btn__style1" onclick="confirmDelete()">삭제하기</button>
                        <a href="../board/boardCate.php?category=질문하기" class="write__btn btn__style1">목록으로</a>
                    </div>
            </section>

            <section id="blogComment" class="blog__comment">
                    <h4>댓글 쓰기</h4>
                    <div class="comment">

                    <?php
    if($commentResult->num_rows == 0){?>
        <div class="comment__view">
            <div class="avata">
                <img src="../../assets/mypage/Img_default.jpg" alt="기본 프로필 이미지">
            </div>
            <div class="texts">
                <span>작성된 댓글이 없습니다.😣</span>
                <p>댓글을 작성해 주세요.</p>
            </div>
        </div>
    <?php } else { 
        foreach($commentResult as $comment){ ?>
            <div class="comment__view">
                <div class="avata">
                    <?php if (!empty($comment['profileImage'])): ?>
                        <img src="../../assets/mypage/<?=$comment['profileImage']?>" alt="사용자 프로필 이미지">
                    <?php else: ?>
                        <img src="../../assets/mypage/Img_default.jpg" alt="기본 프로필 이미지">
                    <?php endif; ?>
                </div>
                <div class="texts">
                    <span>
                        <span class="author"><?= $comment['commentName'] ?>[<?= $comment['youName']?>]</span>
                        <span class="date"><?=date('Y-m-d H:i', $comment['regTime'])?></span>
                        <a href="#" class="modify" data-comment-id="<?=$comment['commentId']?>">수정</a>
                        <a href="#" class="delete" data-comment-id="<?=$comment['commentId']?>">삭제</a>
                    </span>
                    <p><?=$comment['commentMsg']?></p>
                </div>
            </div>
    <?php }
    }
?>
                    <div class="comment__input">
                        <form action="#">
                            <fieldset>
                                <legend class="blind">댓글쓰기</legend>
                                <label for="commentName" class="blind">이름</label>
                                <input type="text" id="commentName" name="commentName" class="input__style" placeholder="이름" required>
                                <label for="commentPass" class="blind">비밀번호</label>
                                <input type="password" id="commentPass" name="commentPass" class="input__style" placeholder="비밀번호" required>
                                <label for="commentWrite" class="blind">댓글쓰기</label>
                                <input type="text" id="commentWrite" name="commentWrite" class="input__style" placeholder="댓글을 써주세요!" required>
                                <button type="button" id="commentWriteBtn" class="commentWriteBtn">댓글 쓰기</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </section>
        </section>
    </main>


    <!-- footer -->
    <?php include "../include/footer.php" ?>
    <div id="popupDelete" class="none">
        <div class="comment__delete">
            <h4>댓글 삭제</h4>
            <label for="commentDeletePass" class="blind">비밀번호</label>
            <input type="password" id="commentDeletePass" name="commentDeletePass" placeholder="비밀번호">
            <p>* 입력했던 비밀번호를 입력해주세요!</p>
            <div class="modify__btn2">
                <button id="commentDeleteCancel">취소</button>
                <button id="commentDeleteButton">삭제</button>
            </div>
        </div>
    </div>

    <div id="popupModify" class="none">
        <div class="comment__modify">
            <h4>댓글 수정</h4>
            <label for="commentModifyMsg" class="blind">비밀번호</label>
            <textarea name="commentModifyMsg" id="commentModifyMsg" rows="4" placeholder="수정할 내용을 적어주세요!"></textarea>
            <input type="password" id="commentModifyPass" name="commentModifyPass" placeholder="비밀번호">
            <p>* 입력했던 비밀번호를 입력해주세요!</p>
            <div class="modify__btn2">
                <button id="commentModifyCancel">취소</button>
                <button id="commentModifyButton">수정</button>
            </div>
        </div>
    </div>

    <!-- 이미지 크게 모달 -->
    <div id="imageModal" class="modal">
        <span class="close-button" onclick="closeImageModal()">&times;</span>
        <img class="modal-content" id="expanded-image">
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>

    // 좋아요 싫어요
    $("#likeButton, #dislikeButton").click(function() {
        var action = $(this).data("action");
        var is_currently_selected = $(this).hasClass("selected") || $(this).hasClass("selected2");
        var boardId = <?= $boardId ?>;
        var memberId = <?= $memberId ?>;

        // 로그인 여부 확인
        if (memberId !== 0) {
            $.ajax({
                url: "updateLikes.php",
                method: "POST",
                data: { likeAction: action, boardId: boardId, isCurrentlySelected: is_currently_selected },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        $("#likeCount").text(data.likeCount);
                        $("#dislikeCount").text(data.dislikeCount);

                        if (action === 'like') {
                            $("#likeButton").toggleClass("selected");
                            $("#dislikeButton").removeClass("selected2");
                        } else if (action === 'dislike') {
                            $("#dislikeButton").toggleClass("selected2");
                            $("#likeButton").removeClass("selected");
                        }
                    } else {
                        alert("이미 좋아요나 싫어요를 눌렀습니다.");
                    }
                },
                error: function() {
                    alert("서버와의 통신 중 오류가 발생했습니다.");
                }
            });
        } else {
            alert("로그인이 필요합니다.");
        }
    });

    let commentId = "";
    // 댓글 쓰기 버튼
    $("#commentWriteBtn").click(function () {
        if ($("#commentWrite").val() == "") {
            alert("댓글을 작성하세요.");
            $("#commentWrite").focus();
        } else {
            // memberId가 1 이상인 경우에만 댓글 작성을 수행
            if (<?=$memberId?> >= 1) {
                $.ajax({
                    url: "boardCommentWrite.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                        "boardId": <?=$boardId?>,
                        "memberId": <?=$memberId?>,
                        "name": $("#commentName").val(),
                        "pass": $("#commentPass").val(),
                        "msg": $("#commentWrite").val(),
                    },
                    success: function (data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function (request, status, error) {
                        console.log("request" + request);
                        console.log("status" + status);
                        console.log("error" + error);
                    }
                });
            } else {
                // memberId가 1 미만인 경우
                alert("로그인이 필요합니다.");
                window.location.href = "../login/login.php";
            }
        }
    });

    // 게시글 수정하기 삭제하기
    function confirmEdit() {
        if (confirm('수정하시겠습니까?')) {
            // 게시물 수정 페이지로 이동
            window.location.href = 'boardModify.php?boardId=<?php echo $boardId; ?>';
        }
    }

    function confirmDelete() {
        if (confirm('정말 삭제하시겠습니까?')) {
            // 게시물 삭제 작업 수행 또는 삭제 페이지로 이동
            // 예를 들어, 게시물 삭제를 처리하는 PHP 페이지로 이동할 수 있습니다.
            window.location.href = 'boardDelete.php?boardId=<?php echo $boardId; ?>';
        }
    }



    // 댓글 삭제 버튼
    $(".comment__view .delete").click(function(e){
        e.preventDefault();
        $("#popupDelete").removeClass("none");
        commentId = $(this).data("comment-id");
    });

    // 댓글 삭제 버튼 ---> 취소 버튼
    $("#commentDeleteCancel").click(function(){
        $("#popupDelete").addClass("none");
    });

    // 댓글 삭제 버튼 ---> 삭제 버튼
    $("#commentDeleteButton").click(function(){
        if($("#commentDeletePass").val() == ""){
            alert("댓글 작성시 비밀번호를 작성해주세요!");
            $("#commentDeletePass").focus();
        } else {
            $.ajax({
                url: "boardCommentDelete.php",
                method: "POST",
                dataType: "json",
                data: {
                    "commentPass": $("#commentDeletePass").val(),
                    "commentId": commentId,
                },
                success: function(data){
                    console.log(data);
                    if(data.result == "bad"){
                        alert("비밀번호가 일치하지 않습니다.");
                    } else {
                        alert("댓글이 삭제되었습니다.");
                    }
                    location.reload();
                },
                error: function(request, status, error){
                    console.log("request" + request);
                    console.log("status" + status);
                    console.log("error" + error);
                }
            })
        }
    });

    // 댓글 수정 버튼
    $(".comment__view .modify").click(function(e){
        e.preventDefault();
        $("#popupModify").removeClass("none");
        commentId = $(this).data("comment-id");

        let commentMsg = $(this).closest(".comment__view").find("p").text();
        $("#commentModifyMsg").val(commentMsg);
    });;

    // 댓글 수정 버튼 ---> 취소 버튼
    $("#commentModifyCancel").click(function(){
        $("#popupModify").addClass("none");
    });

    // 댓글 삭제 버튼 ---> 수정 버튼
    $("#commentModifyButton").click(function(){
        if($("#commentModifyPass").val() == ""){
            alert("댓글 수정시 비밀번호를 작성해주세요!");
            $("#commentModifyPass").focus();
        } else {
            $.ajax({
                url: "boardCommentModify.php",
                method: "POST",
                dataType: "json",
                data: {
                    "commentMsg": $("#commentModifyMsg").val(),
                    "commentPass": $("#commentModifyPass").val(),
                    "commentId": commentId,
                },
                success: function(data){
                    console.log(data);
                    if(data.result == "bad"){
                        alert("비밀번호가 일치하지 않습니다.");
                    } else {
                        alert("댓글이 수정되었습니다.");
                    }
                    location.reload();
                },
                error: function(request, status, error){
                    console.log("request" + request);
                    console.log("status" + status);
                    console.log("error" + error);
                }
            })
        }
    });

    // 이미지 모달 열기
    function openImage(src, alt) {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('expanded-image');
        modal.style.display = 'block';
        modalContent.src = src;
        modalContent.alt = alt;
    }

    // 모달 닫기
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
    }

    // 모달 외부 클릭 시 닫기
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('imageModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    </script>
    
</body>

</html>