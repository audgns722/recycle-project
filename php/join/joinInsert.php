<!DOCTYPE html>
<html lang="ko">
<head>
<?php include "../include/head.php" ?>
    
<style>
    .join__box h2 {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        max-width: 260px;
        height: 60px;
        border-radius: 50px;
        font-size: 1.25rem;
        box-shadow: rgba(0, 0, 0, 0.16) 2px 2px 0px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        letter-spacing: 5px;
        color: #30A99E;
        font-weight: 500;
        margin-bottom: 35px;
    } 
    @media (max-width : 650px) {
        .join__box form {
            width: 95%;
        }
        .login__inner {
            height: auto;
            padding-bottom: 10vh;
        }
        .login__wrap {
            height: auto;
        }
        .login__btn2 {
            margin-bottom: 15px;
        }
        .join__box h2 {
            margin-top: 15px;
        }
    }
</style>
</head>
<body>
    <?php include "../include/header.php" ?>

    <main id="main">
        <div class="login__inner">
            <div class="login__wrap">
                <div class="join__box">
                    <h2>회원가입</h2>
                    <h3>이미 계정이 있습니까?<a href="../login/login.php" class="joinbtn">로그인</a></h3>
                    <form action="joinResult.php" name="joinResult" method="post" onsubmit="return joinChecks();">
                        <div class="join">
                            <label for="youId">
                                <h4>아이디</h4>
                                <input class="joininsert__inpput" type="text" id="youId" name="youId" placeholder="아이디를 입력해주세요">
                                <div class="btn" onclick="idChecking()" >중복 검사</div>
                                <p class="msg" id="youIdComment"></p>
                            </label>
                        </div>
                        <div class="join">
                            <h4>비밀번호</h4>
                            <label for="youPass" class="required">
                                <input type="password" id="youPass" name="youPass" placeholder="비밀번호를 적어주세요!" autocomplete="off" class="input__style">
                                <p class="msg" id="youPassComment"></p>
                            </label>
                        </div>
                        <div class="join">
                            <h4>비밀번호확인</h4>
                            <label for="youPassC" class="required">
                                <input type="password" id="youPassC" name="youPassC" placeholder="비밀번호를 한번더 입력해주세요" autocomplete="off" class="input__style">
                                <p class="msg" id="youPassCComment"></p>
                            </label>
                        </div>
                        <div class="join">
                            <h4>이름</h4>
                            <label for="youName" class="required">
                                <input type="text" id="youName" name="youName" placeholder="이름을 적어주세요!" class="input__style">
                                <p class="msg" id="youNameComment"></p>
                            </label>
                        </div>
                        <div class="joinadress">
                            <label for="youAddress1" class="required"></label>
                            <div class="check">
                                <input type="text" id="youAddress1" name="youAddress1" placeholder="우편번호"
                                    class="input__style">
                                <div class="btn" id="addressCheck">주소 찾기</div>
                            </div>
                            <label for="youAddress2" class="required blind">주소</label>
                            <input type="text" id="youAddress2" name="youAddress2" placeholder="주소"
                                class="input__style">
                            <label for="youAddress3" class="required blind">상세 주소</label>
                            <input type="text" id="youAddress3" name="youAddress3" placeholder="상세 주소"
                                class="input__style">
                            <p class="msg" id="youAddressComment"></p>
                        </div>
                        <div class="join">
                            <h4>휴대폰</h4>
                            <label for="youPhone">
                                <input type="text" id="youPhone" name="youPhone" placeholder="연락처는 하이픈 또는 숫자만 입력하세요!" class="input__style">
                                <p class="msg" id="youPhoneComment"></p>
                            </label>
                        </div> 
                        <div class="join">
                            <h4>생년월일</h4>
                            <label for="youBirth">
                                <input type="text" id="youBirth" name="youBirth" placeholder="생년월일(YYYY-MM-DD)을 입력해주세요." class="input__style">
                                <p class="msg" id="youBirthComment"></p>
                            </label>
                        </div>
                        <button type="submit" id="submitBtn" class="login__btn2 btn__style1">가 입 하 기</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php include "../include/footer.php" ?>
    
    <div id='layer'>
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" alt="닫기 버튼">
    </div>

    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        let isIdCheck = false;

        function idChecking(){
            let youId = $("#youId").val();

            if(youId == null || youId ==''){
                $("#youIdComment").text("**아이디를 입력해주세요!");
            } else {
                // 아이디 유효성 검사
                let getYouId = RegExp(/^[a-zA-Z0-9_-]{4,20}$/);

                if(!getYouId.test($("#youId").val())){
                    $("#youIdComment").text("아이디는 영어와 숫자를 포함하여 4~20글자 이내로 작성성이 가능합니다.");
                    $("#youId").val('');
                    $("#youId").focus();
                    
                    return false;
                } else {
                    $("#youIdComment").text("사용 가능한 아이디입니다.");
                }
                $.ajax({
                    type : "POST",
                    url : "joinCheck.php",
                    data : {"youId" : youId, "type" : "isIdCheck"},
                    dataType : "json",
                    success : function (data){
                        if(data.result == "good"){
                            $("#youIdComment").text("사용 가능한 아이디 입니다.");
                            isIdCheck = true;
                        } else {
                            $("#youIdComment").text("이미 존재하는 아이디 입니다.");
                            isIdCheck = false;
                        }
                    }
                })
            } 

        }
        
        function joinChecks(){
            
            //중복 확인이 이루어 졌는지 검사
            if(!isIdCheck){
                alert("중복 검사를 진행해주세요.");
                return false;
            }

            // 비밀번호 유효성 검사
            if ($("#youPass").val() == '' ){
                $("#youPassComment").text("비밀번호를 입력해주세요");
                $("#youPass").focus();
                return false;
            } else {
                let getYouPass = $("#youPass").val();
                let getYouPassNum = getYouPass.search(/[0-9]/g);
                let getYouPassEng = getYouPass.search(/[a-z]/ig);
                let getYouPassSpe = getYouPass.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

                if(getYouPass.length < 8 || getYouPass.length > 20){
                    $("#youPassComment").text("➟ 8자리 ~ 20자리 이내로 입력해주세요");
                    return false;
                } else if (getYouPass.search(/\s/) != -1){
                    $("#youPassComment").text("➟ 비밀번호는 공백없이 입력해주세요!");
                    return false;
                } else if (getYouPassNum < 0 || getYouPassEng < 0 || getYouPassSpe < 0 ){
                    $("#youPassComment").text("➟ 영문, 숫자, 특수문자를 혼합하여 입력해주세요!");
                    return false;
                } 
            }

            // 비밀번호 확인 유효성 검사
            if($("#youPassC").val() == ''){
                $("#youPassCComment").text("➟ 확인 비밀번호를 입력해주세요!");
                $("#youPassC").focus();
                return false;
            }

            // 비밀번호 동일한지 체크
            if($("#youPass").val() !== $("#youPassC").val()){
                $("#youPassCComment").text("➟ 비밀번호가 일치하지 않습니다.");
                $("#youPass").focus();
                return false;
            }

            // 이름 유효성 검사
            if( $("#youName").val() == '' ){
                $("#youNameComment").text("이름을 입력해주세요!");
                $("#youName").focus();
                return false;
            } else {
                let getYouName = RegExp(/^[가-힣]{3,5}$/);

                if(!getYouName.test($("#youName").val())){
                    $("#youNameComment").text("이름은 한글(3~5글자)만 사용할 수 있습니다.");
                    $("#youName").val('');
                    $("#youName").focus();
                    return false;
                }
            }

            // 휴대폰 번호 유효성 검사
            let getYouPhone = RegExp(/^[0-9()-\s]+$/);

            if (!getYouPhone.test($("#youPhone").val())) {
                $("#youPhoneComment").text("➟ 올바른 휴대폰 번호 형식이 아닙니다. (하이픈 또는 숫자만 입력하세요)");
                $("#youPhone").val('');
                $("#youPhone").focus();
                return false;
            }

            // 생년월일 유효성 검사
            let getYouBirth = RegExp(/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/);

            if (!getYouBirth.test($("#youBirth").val())) {
                $("#youBirth").text("➟ 올바른 생년월일 형식이 아닙니다. (YYYY-MM-DD 형식으로 입력하세요)");
                $("#youBirth").val('');
                $("#youBirth").focus();
                return false;
            }
        }
    </script>
    <script>
        // 우편번호 찾기 화면을 넣을 element
        const layer = document.querySelector("#layer");
        const searchIcon = document.querySelector("#addressCheck");
        const layerCloseBtn = document.querySelector("#btnCloseLayer");

        searchIcon.addEventListener('click', searchBtnClick);
        layerCloseBtn.addEventListener('click', closeDaumPostcode);

        function closeDaumPostcode() {
            // iframe을 넣은 element를 안보이게 한다.
            layer.style.display = 'none';
        }

        const themeObj = {
            //bgColor: "", 바탕 배경색
            searchBgColor: "#0B65C8", //검색창 배경색
            // contentBgColor: "", 본문 배경색(검색결과,결과없음,첫화면,검색서제스트) pageBgColor: "", 페이지 배경색
            // textColor: "", 기본 글자색
            queryTextColor: "#FFFFFF" //검색창 글자색
            // postcodeTextColor: "", 우편번호 글자색 emphTextColor: "", 강조 글자색 outlineColor: "",
            // 테두리
        };

        function searchBtnClick() {
            new daum
                .Postcode({
                    theme: themeObj,
                    oncomplete: function (data) {
                        // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분. 각 주소의 노출 규칙에 따라 주소를 조합한다. 내려오는 변수가 값이 없는 경우엔
                        // 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                        let addr = ''; // 주소 변수
                        let extraAddr = ''; // 참고항목 변수

                        //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                        if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                            addr = data.roadAddress;
                        } else { // 사용자가 지번 주소를 선택했을 경우(J)
                            addr = data.jibunAddress;
                        }



                        document.querySelector('#youAddress1').value = data.zonecode; // 우편번호
                        document.querySelector("#youAddress2").value = addr; // 주소
                        document.querySelector("#youAddress3").focus();

                        // iframe을 넣은 element를 안보이게 한다. (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서
                        // 사라지지 않는다.)
                        layer.style.display = 'none';
                    },
                    width: '100%',
                    height: '100%',
                    maxSuggestItems: 5
                })
                .embed(layer);

            // iframe을 넣은 element를 보이게 한다.
            layer.style.display = 'block';

            // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
            initLayerPosition();
        }

        // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는 resize이벤트나, orientationchange이벤트를 이용하여
        // 값이 변경될때마다 아래 함수를 실행 시켜 주시거나, 직접 layer의 top,left값을 수정해 주시면 됩니다.
        function initLayerPosition() {
            const width = 500; //우편번호서비스가 들어갈 element의 width
            const height = 500; //우편번호서비스가 들어갈 element의 height
            const borderWidth = 5; //샘플에서 사용하는 border의 두께

            // 위에서 선언한 값들을 실제 element에 넣는다.
            layer.style.width = width + 'px';
            layer.style.height = height + 'px';
            layer.style.border = borderWidth + 'px solid';
            // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
            layer.style.left = (
                ((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth
            ) + 'px';
            layer.style.top = (
                ((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth
            ) + 'px';
        }

    </script>
</body>
</html>