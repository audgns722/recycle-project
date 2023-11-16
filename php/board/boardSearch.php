<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    
    $memberId = $_SESSION['memberId'];
    
    if (isset($_GET['searchOption']) && isset($_GET['searchKeyword'])) {
        $searchOption = $_GET['searchOption'];
        $searchKeyword = $_GET['searchKeyword'];
        
        if (empty($searchKeyword)) {
            echo "<script>alert('검색어를 입력하세요.'); window.history.back();</script>";
            exit;
        }

        $allowed_searchOptions = ['boardTitle', 'boardContents', 'boardAuthor']; // 허용된 검색 옵션
        if (!in_array($searchOption, $allowed_searchOptions)) {
            echo "<script>alert('잘못된 검색 옵션입니다.'); window.history.back();</script>";
            exit;
        }
    
        // SQL 쿼리를 수정하여 검색 조건을 포함하도록 변경
        $searchKeyword = mysqli_real_escape_string($connect, $searchKeyword); // searchKeyword 이스케이프 처리
        $searchSql = "SELECT * FROM teamBoard WHERE boardDelete = 1 
                        AND {$searchOption} LIKE '%{$searchKeyword}%' ORDER BY boardId DESC";
    } else {
        // 검색 매개 변수가 제공되지 않은 경우 원래 쿼리를 사용합니다.
        $searchSql = "SELECT * FROM teamBoard WHERE boardDelete = 1 ORDER BY boardId DESC";
    }
    
    $searchResult = $connect->query($searchSql);
    if ($searchResult === false) {
        echo "데이터베이스 쿼리에 실패했습니다: " . mysqli_error($connect); // 에러 메시지 출력
        exit;
    }
    
    $searchCount = $searchResult->num_rows;

    // SQL 쿼리: 각 게시물의 댓글 수를 가져옵니다
    $commentCountSql = "SELECT b.boardId, COUNT(c.commentId) AS commentCount
    FROM teamBoard b
    LEFT JOIN boardComment c ON b.boardId = c.boardId
    GROUP BY b.boardId
    ORDER BY b.boardId DESC";

    // 쿼리 실행
    $commentCountResult = $connect->query($commentCountSql);

    // 한 페이지에 보여질 항목 수
    $viewNum = 10;

    // 현재 페이지 번호를 가져옴
    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    // 시작 레코드 인덱스 계산
    $viewLimit = ($viewNum * $page) - $viewNum;

    // 검색 결과를 페이지네이션을 적용하여 가져오기
    $searchSql .= " LIMIT $viewLimit, $viewNum";
    $searchResult = $connect->query($searchSql);
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
        <div class="board__title container">
            <h1>검색결과</h1>
        </div>
        <section class="board__inner container">
            <div class="board__nav">
                <ul>
                    <li><a href="boardCate.php?category=공지사항">공지사항</a></li>
                    <li><a href="boardCate.php?category=질문하기">질문하기</a></li>
                    <li><a href="boardCate.php?category=문의하기">문의하기</a></li>
                </ul>
            </div>
            <div class="board__search">
                <div class="left">
                    <p>* 분리배출에 관련된 내용을 질문하는 게시판 입니다.</p>
                </div>
                <div class="right">
                    <form action="boardSearch.php" name="boardSearch" method="get">
                        <fieldset>
                            <legend class="blind">게시판 검색 영역</legend>
                            <div class="search__btn">
                                <button type="submit" class="btn__style2">검 색</button>
                                <a href="write.php" class="btn__write btn__style2">글쓰기</a>
                            </div>
                            <select name="searchOption" id="searchOption">
                                <option value="boardTitle">제목</option>
                                <option value="boardContents">내용</option>
                                <option value="boardAuthor">등록자</option>
                            </select>
                            <input type="search" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력하세요!">
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
                        
<?php 
    foreach ($searchResult as $boardSearch) {
        $boardId = $boardSearch['boardId'];
        $commentCount = 0;
    
        // 결과 세트에서 댓글 수를 찾아봅니다.
        foreach ($commentCountResult as $commentCountRow) {
            if ($commentCountRow['boardId'] == $boardId) {
                $commentCount = $commentCountRow['commentCount'];
                break;
            }
        }
    
        echo "<tr>
            <td>{$boardSearch['boardId']}</td>
            <td><a href='boardView.php?boardId={$boardSearch['boardId']}'>{$boardSearch['boardTitle']}<span style='color: blue;'>[{$commentCount}]</span></a></td>
            <td>{$boardSearch['boardAuthor']}</td>
            <td>" . date('Y-m-d', $boardSearch['regTime']) . "</td>
            <td>{$boardSearch['boardView']}</td>
            </tr>";
    }
?>

                    </tbody>
                </table>
            </div>

            <div class="board__pages">
                <ul>
<?php
    // 현재 페이지
    $currentPage = $page;
    $boardTotalCount = $searchCount; // 검색 결과의 총 갯수

    // 총 페이지 갯수 계산
    $boardTotalCount = ceil($boardTotalCount / $viewNum);

    // 이전 페이지, 처음으로 가기
    if ($page > 1) {
        echo "<li class='first'><a href='boardSearch.php?page=1&searchOption=$searchOption&searchKeyword=$searchKeyword'>❰❰</a></li>";
        echo "<li class='prev'><a href='boardSearch.php?page=" . ($page - 1) . "&searchOption=$searchOption&searchKeyword=$searchKeyword'>❰</a></li>";
    }

    // 페이지
    for ($i = 1; $i <= $boardTotalCount; $i++) {
        $active = "";
        if ($i == $page) $active = "active";

        echo "<li class='{$active}'><a href='boardSearch.php?page={$i}&searchOption=$searchOption&searchKeyword=$searchKeyword'>${i}</a></li>";
    }

    // 다음 페이지, 마지막으로 가기
    if ($page < $boardTotalCount) {
        echo "<li class='next'><a href='boardSearch.php?page=" . ($page + 1) . "&searchOption=$searchOption&searchKeyword=$searchKeyword'>❱</a></li>";
        echo "<li class='last'><a href='boardSearch.php?page={$boardTotalCount}&searchOption=$searchOption&searchKeyword=$searchKeyword'>❱❱</a></li>";
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