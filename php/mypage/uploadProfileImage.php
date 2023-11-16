<?php
include "../connect/connect.php";
include "../connect/session.php";

// 프로필 이미지 변경하기
// 파일 업로드 처리 및 데이터베이스 업데이트
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memberId = $_SESSION['memberId'];

    // 파일 업로드 처리
    $targetDir = "../../assets/mypage/"; // 저장할 디렉토리 설정

    // 파일의 원래 이름
    $originalFileName = basename($_FILES["mypageFile"]["name"]);

    // 확장자를 포함하지 않는 파일 이름과 확장자를 분리
    $fileNameWithoutExt = pathinfo($originalFileName, PATHINFO_FILENAME);
    $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

    // 현재 시간의 타임스탬프를 파일 이름에 추가
    $newFileName = $fileNameWithoutExt . "_" . time() . "." . $fileExtension;

    $targetFile = $targetDir . $newFileName;
    $uploadOk = 1;

    // 이미지 파일 유형 확인
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["mypageFile"]["tmp_name"]);
        if ($check !== false) {
            echo "파일은 이미지입니다 - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "파일은 이미지가 아닙니다.";
            $uploadOk = 0;
        }
    }

    // 이미 파일이 존재하는지 확인
    if (file_exists($targetFile)) {
        echo "<script>alert('파일이 이미 존재합니다.')</script>";
        echo "<script>window.history.back();</script>";
        $uploadOk = 0;
    }

    // 파일 크기 제한 (1MB 이하)
    if ($_FILES["mypageFile"]["size"] > 1000000) {
        echo "<script>alert('파일 용량이 큽니다 1MB 이하로 업로드 해주세요.')</script>";
        echo "<script>window.history.back();</script>";
        $uploadOk = 0;
    }

    // 허용되는 파일 형식 지정
    if ($fileExtension != "jpg" && $fileExtension != "gif" && $fileExtension != "webp" && $fileExtension != "png") {
        echo "JPG, GIF, WEBP, PNG 파일만 허용됩니다.";
        $uploadOk = 0;
    }

    // 업로드가 가능한 경우, 파일을 이동하고 데이터베이스 업데이트
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["mypageFile"]["tmp_name"], $targetFile)) {
            // 데이터베이스에 이미지 경로 업데이트 (teamMembers 테이블)
            $imagePath = $targetFile; // 이미지 파일의 경로
            $updateSql = "UPDATE teamMembers SET youImgSrc = '$imagePath' WHERE memberId = $memberId";
            $connect->query($updateSql);

            // 데이터베이스에 이미지 경로 업데이트 (boardComment 테이블)
            $updateCommentSql = "UPDATE boardComment SET profileImage = '$imagePath' WHERE memberId = $memberId";
            $connect->query($updateCommentSql);

            echo "<script>alert('프로필 이미지가 변경되었습니다.')</script>";
            echo "<script>window.history.back();</script>";
        } else {
            echo "<script>alert('프로필 이미지 업로드에 실패하셨습니다.')</script>";
            echo "<script>window.history.back();</script>";
        }
    }
}
?>
