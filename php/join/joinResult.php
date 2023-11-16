<?php
    include "../connect/connect.php";

    $youId = mysqli_real_escape_string($connect, $_POST['youId']);
    $youPass = mysqli_real_escape_string($connect, $_POST['youPass']);
    $youName = mysqli_real_escape_string($connect, $_POST['youName']);
    $youPhone = mysqli_real_escape_string($connect, $_POST['youPhone']);
    $youBirth = mysqli_real_escape_string($connect, $_POST['youBirth']);
    $youAddress = mysqli_real_escape_string($connect, $_POST['youAddress']);
    $regTime = time();

    $sql = "INSERT INTO teamMembers(youId, youPass, youName, youAddress, youPhone, youBirth, regTime) VALUES('$youId', '$youPass', '$youName', '$youAddress', '$youPhone', '$youBirth', '$regTime')";
    $connect -> query($sql);

    // 데이터 베이스 연결 닫기
    mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="ko">
<?php include "../include/head.php" ?>
    
<style>

    .login__box form {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 2rem;
    }
    .CheckMsg {
        width: 353px;
        margin-top: 5px;
        display: flex;
        white-space: wrap;
        justify-content: space-between;
    }
    .msg {
        /* width: 50%; */
        color : red;
        font-weight: 500;
        font-size: 0.8rem;
        margin-top: 5px;
    }
    .join label {
        width: 353px;
        display: flex;
        flex-wrap : wrap;
        justify-content: space-between;
        align-items: center;
    }
    #youId {
        /* width: 250px; */
        margin-top: 0;
    }
    #youId {
        width: 72%;
    }
    .btn {
        width: 25%;
        background-color: var(--mycolor1);
        color : var(--white);
        text-align: center;
        padding: 5px;
        cursor: pointer;
        display: inline-block;
        font-size: 0.8rem;
        border-radius: 5px;
    }
    @media (max-width : 650px) {
        .login__box {
            height: 530px;
        }
        .images__wrap {
            height: 70vh;
        }
    }
</style>
</head>
<body>
    <?php include "../include/header.php" ?>

    <main id="main">
        <div class="login__inner">
            <div class="login__wrap">
                <div class="login__box">
                    <h2>로 그 인</h2>
                    <h3>회원가입을 축하드립니다.</h3>
                    <form action="../login/loginSave.php" name="loginSave" method="post" class="login__form">
                        <label for="youId">
                            아이디<input class="login__id"type="text" id="youId" name="youId">
                        </label>
                        <label for="youPass">
                            비밀번호<input type="password" id="youPass" name="youPass">
                        </label>
                        <div class="login__find">
                            <a href="../join/joinId.php">아이디 찾기</a>
                            <a href="../join/joinpass.php">비밀번호 찾기</a>
                        </div>
                        <button class="login__btn2">로그인 하기</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <?php include "../include/footer.php" ?>

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
                alert("중복 검사를 진행해주세요.")
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
            if($("#youpassC").val() == ''){
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
</body>
</html>