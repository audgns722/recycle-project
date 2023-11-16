<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if(isset($_GET['category'])){
        $category = $_GET['category'];
    } else {
        Header("Location: board.php");
    }

    $memberId = $_SESSION['memberId'];
    $categorySql = "SELECT * FROM teamBoard WHERE boardDelete = 1 AND boardCategory = '$category' ORDER BY boardId DESC";
    $categoryResult = $connect -> query($categorySql);
    $categoryInfo = $categoryResult -> fetch_array(MYSQLI_ASSOC);
    $categoryCount = $categoryResult -> num_rows;

    // SQL 쿼리: 각 게시물의 댓글 수를 가져옵니다
    $commentCountSql = "SELECT b.boardId, COUNT(c.commentId) AS commentCount FROM teamBoard b LEFT JOIN boardComment c ON b.boardId = c.boardId GROUP BY b.boardId ORDER BY b.boardId DESC";

    // 쿼리 실행
    $commentCountResult = $connect->query($commentCountSql);

    $viewNum = 10; // 한 페이지에 보여질 항목 수
    $boardTotalCount = ceil($categoryCount / $viewNum); // 총 페이지 수 계산

    // 현재 페이지 번호를 가져옴
    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    // 시작 레코드 인덱스 계산
    $viewLimit = ($viewNum * $page) - $viewNum;

    // 게시물 목록을 가져오는 쿼리
    $boardListSql = "SELECT * FROM teamBoard WHERE boardDelete = 1 AND boardCategory = '$category' ORDER BY boardId DESC LIMIT $viewLimit, $viewNum";
    $boardListResult = $connect->query($boardListSql);

    // 시작 레코드 인덱스 계산
    $viewLimit = ($viewNum * $page) - $viewNum;
    
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include "../include/head.php" ?>
</head>

<body>
    <?php include "../include/header.php" ?>

    <!-- main -->
    <main id="main">
        <section class="board__inner container">
            <div class="board__nav">
            <ul>
                <li <?php echo ($category === '공지사항') ? 'class="active"' : ''; ?>>
                    <a href="boardCate.php?category=공지사항">공지사항</a>
                </li>
                <li <?php echo ($category === '질문하기') ? 'class="active"' : ''; ?>>
                    <a href="boardCate.php?category=질문하기">질문하기</a>
                </li>
                <li <?php echo ($category === '문의하기') ? 'class="active"' : ''; ?>>
                    <a href="boardCate.php?category=문의하기">문의하기</a>
                </li>
            </ul>
            </div>
            <div class="board__search">
                <div class="left">
                <p>* 분리배출 <?=$category?> 게시판 입니다.</p>
                </div>
                <div class="right">
                    <form action="boardSearch.php" name="boardSearch" method="get">
                        <fieldset>
                            <legend class="blind">게시판 검색 영역</legend>
                            <select name="searchOption" id="searchOption">
                                <option value="boardTitle">제목</option>
                                <option value="boardContents">내용</option>
                                <option value="boardAuthor">작성자</option>
                            </select>
                            <input type="search" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력하세요!">
                            <div class="search__btn">
                                <button type="submit" class="btn__style1">검 색</button>
                                <a href="write.php" class="btn__write btn__style1">글쓰기</a>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="board__table">
                <table>
                    <colgroup>
                        <col style="width: 10%;">
                        <col class="table__col2">
                        <col style="width: 10%;">
                        <col style="width: 15%;">
                        <col style="width: 10%;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>등록자</th>
                            <th>등록일</th>
                            <th>조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php while ($boardCate = $boardListResult->fetch_array(MYSQLI_ASSOC)) { ?>
                        <tr>
                            <td><?=$boardCate['boardId']?></td>
                            <td>
                                <a href='boardView.php?boardId=<?=$boardCate['boardId']?>'><?=$boardCate['boardTitle']?></a>
                                <?php
                                    // 해당 게시물의 댓글 수를 찾아서 표시합니다.
                                    $postId = $boardCate['boardId'];
                                    $commentCount = 0;

                                    // 결과 세트에서 댓글 수를 찾아봅니다.
                                    foreach ($commentCountResult as $commentCountRow) {
                                        if ($commentCountRow['boardId'] == $postId) {
                                            $commentCount = $commentCountRow['commentCount'];
                                            break;
                                        }
                                    }

                                    echo " <span style='color: blue;'>[$commentCount]</span>";
                                ?>
                            </td>
                            <td><?=$boardCate['boardAuthor']?></td>
                            <td><?=date('Y-m-d', $boardCate['regTime'])?></td>
                            <td><?=$boardCate['boardView']?></td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>

            <div class="board__pages">
                <ul>
                    <?php
                        // 현재 페이지
                        $currentPage = $page;

                        // 이전 페이지, 처음으로 가기
                        if ($page > 1) {
                            echo "<li class='first'><a href='boardCate.php?category=$category&page=1'>❰❰</a></li>";
                            echo "<li class='prev'><a href='boardCate.php?category=$category&page=" . ($page - 1) . "'>❰</a></li>";
                        }

                        // 페이지
                        for ($i = 1; $i <= $boardTotalCount; $i++) {
                            $active = ($i == $page) ? 'active' : ''; // 현재 페이지인 경우 active 클래스 추가
                            echo "<li class='{$active}'><a href='boardCate.php?category=$category&page={$i}'>${i}</a></li>";
                        }

                        // 다음 페이지, 마지막으로 가기
                        if ($page < $boardTotalCount) {
                            echo "<li class='next'><a href='boardCate.php?category=$category&page=" . ($page + 1) . "'>❱</a></li>";
                            echo "<li class='last'><a href='boardCate.php?category=$category&page={$boardTotalCount}'>❱❱</a></li>";
                        }
                    ?>
                </ul>
            </div>
        </section>
    </main>


    <!-- footer -->
    <?php include "../include/footer.php" ?>
    
</body>

</html>
