<?php
include "../connect/connect.php";
include "../connect/session.php";

// 게시물 수정 양식에서 POST로 전송된 데이터 받기
$boardId = $_POST['boardId'];
$boardTitle = $_POST['boardTitle'];
$boardContents = $_POST['boardContents'];
$memberId = $_SESSION['memberId'];


// 이미지 파일 업로드 처리
$boardFile = $_FILES['boardFile'];
$boardImgSize = $boardFile['size'];
$boardImgType = $boardFile['type'];
$boardImgName = $boardFile['name'];
$boardImgTmp = $boardFile['tmp_name'];

// 이미지 파일이 업로드되었을 경우
if ($boardImgSize > 0) {
    // 이미지 업로드 및 데이터베이스 저장
    $fileTypeExtension = explode("/", $boardImgType);
    $fileType = $fileTypeExtension[0];  // image
    $fileExtension = $fileTypeExtension[1];  // 확장자(jpg, jpeg, png, gif, webp)

    // 이미지 타입 확인
    if ($fileType === "image") {
        if (in_array($fileExtension, ["jpg", "jpeg", "png", "gif", "webp"])) {
            // 이미지 파일을 업로드할 폴더 및 파일명 설정
            $boardImgDir = "../../assets/board/";
            $newFileName = "Img_" . time() . rand(1, 99999) . "." . $fileExtension; // 새로운 파일 이름
            $newFilePath = $boardImgDir . $newFileName;

            // 이미지 파일 업로드 및 데이터베이스 업데이트
            if (move_uploaded_file($boardImgTmp, $newFilePath)) {
                $boardTitle = $connect->real_escape_string($boardTitle);
                $boardContents = $connect->real_escape_string($boardContents);
                $sql = "UPDATE teamBoard SET boardTitle = '$boardTitle', boardContents = '$boardContents', boardImgFile = '$newFileName' WHERE boardId = '$boardId'";

                if ($connect->query($sql)) {
                    echo "<script>alert('게시글 및 이미지가 성공적으로 수정되었습니다.')</script>";
                    echo "<script>window.location.href = 'board.php';</script>";
                } else {
                    echo "<script>alert('게시글 수정 중 오류 발생: " . $connect->error . "')</script>";
                }
            } else {
                echo "<script>alert('이미지 파일을 업로드하는 중에 문제가 발생했습니다.')</script>";
            }
        } else {
            echo "<script>alert('올바른 이미지 확장자가 아닙니다. jpg, jpeg, png, gif, webp 파일만 허용됩니다.')</script>";
        }
    } else {
        echo "<script>alert('이미지 파일이 아닙니다')</script>";
    }
} else {
    // 이미지가 업로드되지 않은 경우, 이미지 파일 업데이트 없이 게시물만 업데이트
    $boardTitle = $connect->real_escape_string($boardTitle);
    $boardContents = $connect->real_escape_string($boardContents);
    $sql = "UPDATE teamBoard SET boardTitle = '$boardTitle', boardContents = '$boardContents' WHERE boardId = '$boardId'";

    if ($connect->query($sql)) {
        echo "<script>alert('게시글이 성공적으로 수정되었습니다.')</script>";
        echo "<script>window.location.href = 'board.php';</script>";
    } else {
        echo "<script>alert('게시글 수정 중 오류 발생: " . $connect->error . "')</script>";
    }
}

// 입력값을 이스케이프하여 SQL 인젝션 방어
$newboardTitle = $connect->real_escape_string($boardTitle);
$newboardContents = $connect->real_escape_string($boardContents);

// 게시물 정보를 가져옴
$getInfoSql = "SELECT * FROM teamBoard WHERE boardId = '$boardId'";
$infoResult = $connect->query($getInfoSql);
$info = $infoResult->fetch_array(MYSQLI_ASSOC);

if ($info) {
    // 게시물 수정
    $sql = "UPDATE teamBoard SET boardTitle = '{$newboardTitle}', boardContents = '{$newboardContents}' WHERE boardId = '{$boardId}'";
    $result = $connect->query($sql);

    if ($result) {
        // 게시물 수정 성공 시
        echo "<script>alert('게시글이 성공적으로 수정되었습니다.')</script>";
        echo "<script>window.location.href = 'board.php';</script>";
    } else {
        // 게시물 수정 실패 시
        echo "<script>alert('게시글 수정에 실패했습니다. 관리자에게 문의하세요.')</script>";
        echo "<script>window.history.back();</script>";
        echo "Error: " . $connect->error;
    }
} else {
    echo "게시물을 가져올 수 없습니다.";
    echo "Error: " . $connect->error;
}

?>
