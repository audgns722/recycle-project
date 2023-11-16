<?php
if (isset($_GET['category'])) {
    $category = $_GET['category'];
}
// 초기에 표시할 카테고리 (예: '가구')
$initialCategory = '가구';

if (isset($_GET['subcate'])) {
    $selectedCategory = $_GET['subcate'];
} else {
    $selectedCategory = $initialCategory;
}
?>
<style>
    .btn_gotop {
        width: 105px;
        height: 40px;
        display: none;
        position: fixed;
        font-size: 15px;
        font-weight: normal;
        bottom: 100px;
        right: 70px;
        z-index: 999;
        outline: none;
        background-color: #285A5B;
        color: var(--white);
        cursor: pointer;
        border-radius: 50px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }
    .btn_gotop:hover {
        background-color: #15625b;
    }
    .mypagebtn{
        display: flex !important;
        align-items: center !important;
    }
    .mypagebtn span {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-image: url(../../assets/img/mypageicon.svg);
        background-position: center center;
        background-size: cover;
        margin: 0 !important;
        margin-left: 2px;
    }
    @media (max-width:1100px) {
        .btn_gotop {
            width: 100px;
            bottom: 50px;
            right: 40px;
        }
    }
</style>
<!-- 상단으로 이동하기 버튼 -->
<a href="#" class="btn_gotop">맨위로가기</a>
<header id="header">
    <div class="header__bar">
        <div class="text">
            <a href="../main/main.php"><span>홈으로 가고 싶다면</span></a>
            <a href="../subcate/subcate.php?subcate=가구">
                <span>검색하기</span>
                <div class="headerplay"></div>
            </a>
        </div>
    </div>

    <div class="header__main">
        <div class="header__wrap">
            <div class="header__logo"><a href="../main/main.php"><img src="../../assets/img/logo.png" alt="사이트로고"></a></div>
            <nav class="header__nav">
                <ul>
                    <li><a href="../subboard/submain.php">분리배출</a></li>
                    <li><a href="../main/main.php#quizSection" onclick="scrollToQuizSection(event)">퀴즈풀기</a></li>
                    <li><a href="../board/boardCate.php?category=공지사항">커뮤니티</a></li>
                </ul>
                <span>|</span>
<?php if (isset($_SESSION['memberId'])) { ?>
                <ul>
                    <li><a class="mypagebtn" href="../mypage/mypage.php"><?= $_SESSION['youName'] ?>님<span></span></a></li>
                    <li><a href="../login/logout.php">로그아웃</a></li>
                </ul>
<?php } else { ?>
                <ul>
                    <li><a href="../join/joinAgree.php">회원가입</a></li>
                    <li><a href="../login/login.php">로그인</a></li>
                </ul>
<?php } ?>
            </nav>
            <div class="header__nav__mobile" id="headerToggle" aria-controls="primary-menu" aria-expanded="false" role="button">
                <span></span>
            </div>
            <div class="header__hamber">
                <ul>
                    <li><a href="../subboard/submain.php"><em>분리배출</em></a></li>
                    <li><a href="../subcate/subcate.php?subcate=가구">가구</a></li>
                    <li><a href="../subcate/subcate.php?subcate=가전">가전</a></li>
                    <li><a href="../subcate/subcate.php?subcate=용기포장">용기포장</a></li>
                    <li><a href="../subcate/subcate.php?subcate=패션잡화">패션잡화</a></li>
                    <li><a href="../subcate/subcate.php?subcate=음식물">음식물</a></li>
                    <li><a href="../subcate/subcate.php?subcate=기타">기타</a></li>
                    <li><a href="#"><em>퀴즈풀기</em></a></li>
                    <li><em>게시판</em></li>
                    <li><a href="../board/boardCate.php?category=공지사항">공지사항</a></li>
                    <li><a href="../board/boardCate.php?category=질문하기">질문하기</a></li>
                    <li><a href="../board/boardCate.php?category=문의하기">커뮤니티</a></li>
                    <li><em>기타</em></li>
                    <li><a href="../subboard/makers.php">만든사람들</a></li>
                    <li><a href="../subboard/footprint.php">탄소발자국</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- //header -->
<script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.27/bundled/lenis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script>
     function handleQuizLinkClick(event) {
        event.preventDefault();

        // 퀴즈 섹션으로 부드럽게 스크롤 이동 (같은 페이지 내에 있을 때)
        if (isSamePageLink(event.target.href)) {
            scrollToQuizSection();
        } else {
            // 다른 페이지로 이동 후 퀴즈 섹션으로 스크롤 이동
            window.location.href = event.target.href;
        }
    }

    function scrollToQuizSection() {
        // 퀴즈 섹션으로 부드럽게 스크롤 이동
        document.getElementById('quizSection').scrollIntoView({ behavior: 'smooth' });
    }

    function isSamePageLink(href) {
        // 현재 URL과 링크의 URL이 같은 페이지인지 확인
        return new URL(href).pathname === window.location.pathname;
    }

    // 스무스효과
    const lenis = new Lenis()

    lenis.on('scroll', ScrollTrigger.update)

    gsap.ticker.add((time)=>{
    lenis.raf(time * 1000)
    })

    gsap.ticker.lagSmoothing(0)
    
    //gotop script
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.btn_gotop').show();
        } else {
            $('.btn_gotop').hide();
        }
    });
    $('.btn_gotop').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 400);
        return false;
    });

    // nav script

    const headerToggle = document.getElementById("headerToggle");
    const headerNav = document.querySelector(".header__hamber");

    if(headerToggle){
        headerToggle.addEventListener("click", () =>{
            headerNav.classList.toggle("show");

            headerToggle.getAttribute("aria-expanded") === "true" 
            ? headerToggle.setAttribute("aria-expanded", "false")
            : headerToggle.setAttribute("aria-expanded", "true");
        });
    }
</script>