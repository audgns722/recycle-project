<?php 
    include "../connect/connect.php";
    include "../connect/session.php";

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
        <section class="subpageWrap">
            <div class="sub__top">
                <div class="sub__pages main__top">
                    <!-- 검색어 입력 상자 추가 -->
                    <form class="subSearch" method="GET" action="../subcate/subcate.php">
                        <input type="text" name="search" placeholder="검색어를 입력하세요">
                        <button type="submit" value="검색" class="">ENTER</button>
                    </form>
                </div>
            </div>
            <div class="submain">
                <div class="subText">
                    <div>
                        <h2>Recycle</h2>
                        <p>분리배출 방법을 모르겠다면<br>
                        아래 카테고리를 클릭해주세요.</p>
                    </div>
                </div>
                <div class="subnav">
                    <ul class="scroll__style">
                        <a href="../subcate/subcate.php?subcate=가구"><li class="s1"><span>가구</span></li></a>
                        <a href="../subcate/subcate.php?subcate=가전"><li class="s2"><span>가전</span></li></a>
                        <a href="../subcate/subcate.php?subcate=용기포장"><li class="s3"><span>용기포장</span></li></a>
                        <a href="../subcate/subcate.php?subcate=패션잡화"><li class="s4"><span>패션잡화</span></li></a>
                        <a href="../subcate/subcate.php?subcate=음식물"><li class="s5"><span>음식물</span></li></a>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php" ?>
    <!-- //footer -->

    <?php include "../include/mainjs.php" ?>
    <!-- //script -->

</body>

</html>