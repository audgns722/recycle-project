<?php
include "../connect/connect.php";
include "../connect/session.php";

if (isset($_SESSION['youName'])) {
    $boardAuthor = $_SESSION['youName'];
} else {
    $boardAuthor = '관리자'; // 세션이 없을 경우 기본값 설정
}

$boardTitle = $_POST['boardTitle'];
$boardContents = nl2br($_POST['boardContents']);

if(!isset($_SESSION['memberId'])) {
    echo "<script>alert('로그인을 해주세요');</script>";
    echo '<script>window.location.href = "../login/login.php";</script>';
}
if (empty($boardTitle) || empty($boardContents)) {
    echo "<script>alert('제목 또는 내용을 입력해야 합니다.');</script>";
    echo "<script>window.history.back();</script>";
} else {
    $memberId = $_SESSION['memberId'];
    $boardCategory = $_POST['boardCategory'];
    $boardAuthor = $_SESSION['youName'];
    $boardView = 0;
    $boardLike = 0;
    $boardDislike = 0;
    $regTime = time();
    $boardDelete = 1;

    $boardFile = $_FILES['boardFile'];
    $boardImgSize = $boardFile['size'];
    $boardImgType = $boardFile['type'];
    $boardImgName = $boardFile['name'];
    $boardImgTmp = $boardFile['tmp_name'];

    if ($boardImgSize > 0) {
        // 이미지 파일 업로드 및 데이터베이스 저장 로직
        $fileTypeExtension = explode("/", $boardImgType);
        $fileType = $fileTypeExtension[0];  // image
        $fileExtension = $fileTypeExtension[1];  // 확장자(jpg, jpeg, png, gif, webp)

        // 이미지 타입 확인
        if ($fileType === "image") {
            if (in_array($fileExtension, ["jpg", "jpeg", "png", "gif", "webp"])) {
                $boardImgDir = "../../assets/board/";
                $newFileName = "Img_" . time() . rand(1, 99999) . "." . $fileExtension; // 새로운 파일 이름
                $sql = "INSERT INTO teamBoard(memberId, boardTitle, boardContents, boardCategory, boardAuthor, boardView, regTime, boardImgFile, boardImgSize, boardDelete) VALUES('$memberId', '$boardTitle', '$boardContents', '$boardCategory', '$boardAuthor', '$boardView', '$regTime', '$newFileName', '$boardImgSize', '$boardDelete')";
            } else {
                echo "<script>alert('올바른 이미지 확장자가 아닙니다. jpg, jpeg, png, gif, webp 파일만 허용됩니다.')</script>";
                echo "<script>window.history.back();</script>";
            }
            echo "<script>alert('이미지 파일이 맞습니다')</script>";
        } else {
            echo "<script>alert('이미지 파일이 아닙니다')</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        $newFileName = "Img_default.jpg"; // 기본 이미지 파일 이름
        $sql = "INSERT INTO teamBoard(memberId, boardTitle, boardContents, boardCategory, boardAuthor, boardView, regTime, boardImgFile, boardImgSize, boardDelete) VALUES('$memberId', '$boardTitle', '$boardContents', '$boardCategory', '$boardAuthor', '$boardView', '$regTime', '$newFileName', '$boardImgSize', '$boardDelete')";
    }

    // 이미지 사이즈 확인
    if ($boardImgSize > 10000000) {
        echo "<script>alert('이미지 파일 용량이 1MB보다 초과했습니다. 사이즈를 줄여주세요.')</script>";
        echo "<script>window.history.back();</script>";
    } else {
        $result = $connect->query($sql);

        if ($result) {
            if ($boardImgSize > 0) {
                if (move_uploaded_file($boardImgTmp, $boardImgDir . $newFileName)) {
                    echo "<script>alert('저장이 완료되었습니다.');</script>";
                    echo "<script>window.location.href = 'board.php';</script>";
                } else {
                    echo "<script>alert('이미지 파일을 저장하는 중에 문제가 발생했습니다.');</script>";
                    echo "<script>window.history.back();</script>";
                }
            } else {
                echo "<script>alert('저장이 완료되었습니다.');</script>";
                echo "<script>window.location.href = 'board.php';</script>";
            }
        } else {
            echo "<script>alert('데이터베이스에 저장 중 오류가 발생했습니다.');</script>";
            echo "<script>window.history.back();</script>";
        }
    }
}
?>
