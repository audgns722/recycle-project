<?php
include "../connect/connect.php";
include "../connect/session.php";
$jsonFile = 'teample.json';
$jsonData = file_get_contents($jsonFile);
$contentArray = json_decode($jsonData, true);

// 초기에 표시할 카테고리 (예: '가구')
$initialCategory = '가구';

if (isset($_GET['subcate'])) {
    $selectedCategory = $_GET['subcate'];
} else {
    $selectedCategory = $initialCategory;
}

if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];

    // 검색어가 비어 있지 않은 경우에만 필터링
    if (!empty($searchKeyword)) {
        // JSON 데이터를 반복하면서 검색어가 Keyword에 포함되어 있는 페이지를 찾음
        $filteredContent = array_filter($contentArray, function ($content) use ($searchKeyword) {
            // Keyword 문자열에서 검색어가 포함되어 있는지 확인
            return strpos($content['Keyword'], $searchKeyword) !== false;
        });

        // 필터링된 결과를 배열로 변환하여 페이지에 표시
        $filteredContent = array_values($filteredContent);
    } else {
        // 검색어가 없을 경우, $filteredContent를 빈 배열로 초기화
        $filteredContent = [];
    }
} else {
    // 검색어가 없을 경우, 이전과 같이 카테고리 기반으로 필터링
    $filteredContent = array_filter($contentArray, function ($content) use ($selectedCategory) {
        return $content['BigCate'] === $selectedCategory;
    });

    $filteredContent = array_values($filteredContent);
}

// 페이지 번호 가져오기
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// 한 페이지에 표시할 아이템 수
$itemsPerPage = 1;

// 시작 아이템 인덱스 계산
$startIndex = ($currentPage - 1) * $itemsPerPage;

// Filter content by selected category
$filteredContent = array_values($filteredContent);

// 페이지네이션을 위해 배열 재정렬
$filteredContent = array_values($filteredContent);

// 페이지에 표시할 아이템 가져오기
$pageContent = array_slice($filteredContent, $startIndex, $itemsPerPage);

// 전체 페이지 수 계산
$totalPages = ceil(count($filteredContent) / $itemsPerPage);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <?php include "../include/head.php" ?>
    <style>
        #header {
            background-color: #009688;
        }
    </style>
</head>

<body>
    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main">
        <section class="subWrap">
            <div class="sub__section1">
                <div class="section1__wrap">
                    <h2>분리배출 카테고리</h2>
                    <div class="inner__nav">
                        <ul>
<?php
    $categories = array('가구', '가전', '용기포장', '패션잡화', '음식물', '기타');
    foreach ($categories as $category) {
        $isActive = ($selectedCategory === $category) ? 'active' : '';
        echo "<a href=\"../subcate/subcate.php?subcate={$category}\" class=\"{$isActive}\">{$category}</a>";
    }
?>
                        </ul>
                        <div class="sub__pages">
                        <!-- 검색어 입력 상자 추가 -->
                        <form class="subSearch cateSearch" method="GET">
                            <input type="text" name="search" placeholder="검색어를 입력하세요">
                            <button type="submit" value="검색" class="">ENTER</button>
                        </form>
                        <ul>
                            <li>
<?php // 페이지네이션 링크 출력
    for ($i = 1; $i <= $totalPages; $i++) {
        $isActivePage = ($i == $currentPage) ? 'active' : '';
        echo "<a href=\"?subcate={$selectedCategory}&page={$i}\" class=\"{$isActivePage}\">{$i}</a>";
    }
?>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
<?php 
    if (count($filteredContent) <= 0) {
        // 검색 결과가 없을 경우 메시지 출력
        echo '<div><p class="result__none">검색 결과가 없습니다.</p><div>';
    }
?>
            <div class="sub__section2">
                <div class="inner__box">
                    <div class="inner__img">
<?php
    foreach ($pageContent as $content) {
        $imgPath = '../../assets/subcateimg/' . $content['Img'];
        echo "<img src='{$imgPath}' alt=''>";
    }
?>
                    </div>
                </div>
                <div class="inner__box2">
<?php
    // Display filtered content
    echo '<div id="contentContainer">';
    if (count($filteredContent) > 0) {
        // 검색 결과가 있을 경우 내용 출력
        foreach ($pageContent as $content) {
            echo '<h1>' . $content['BigCate'] . '</h1>';
            echo '<p>' . $content['Keyword'] . '</p';
            echo '<ul>';
            foreach ($content['Desc'] as $desc) {
                echo '<li>' . $desc . '</li>';
            }
            echo '</ul>';
            echo '<h2>Tips</h2>';
            echo '<ul>';
            foreach ($content['TipDesc'] as $tip) {
                echo '<li>' . $tip . '</li>';
            }
            echo '</ul>';
            echo '<p class="etc">Etc: ' . $content['Etc'] . '</p>';
        echo '</div>';
        }
    }
?>

                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <?php include "../include/mainjs.php" ?>
    <!-- //script -->

    <script>

    </script>
</body>

</html>
