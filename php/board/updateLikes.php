<?php
include "../connect/connect.php";
include "../connect/session.php";

// 사용자 세션에서 memberId 가져오기
if(isset($_SESSION['memberId'])){
    $memberId = $_SESSION['memberId'];
} else {
    // 사용자가 로그인하지 않은 경우, 기본값 0으로 설정
    $memberId = 0;
}

// 좋아요 또는 싫어요 추가
if (isset($_POST['boardId']) && isset($_POST['likeAction'])) {
    // 로그인한 사용자만 좋아요 또는 싫어요를 클릭할 수 있도록 처리
    if ($memberId != 0) {
        $boardId = $_POST['boardId'];
        $likeAction = $_POST['likeAction'];

        // 사용자가 이미 좋아요 또는 싫어요를 클릭했는지 확인
        $checkSql = "SELECT * FROM teamLikes WHERE memberId = '$memberId' AND boardId = '$boardId'";
        $checkResult = $connect->query($checkSql);

        if ($checkResult->num_rows > 0) {
            // 사용자가 이미 좋아요 또는 싫어요를 클릭한 경우
            $isCurrentlySelected = $_POST['isCurrentlySelected'];

            // 좋아요나 싫어요를 취소
            if ($isCurrentlySelected == 'true') {
                if ($likeAction === 'like') {
                    $sql = "UPDATE teamBoard SET boardLike = boardLike - 1 WHERE boardId = '$boardId'";
                } elseif ($likeAction === 'dislike') {
                    $sql = "UPDATE teamBoard SET boardDislike = boardDislike - 1 WHERE boardId = '$boardId'";
                }

                // 데이터베이스에서 해당 좋아요나 싫어요 정보 삭제
                $deleteSql = "DELETE FROM teamLikes WHERE memberId = '$memberId' AND boardId = '$boardId'";
                $connect->query($deleteSql);
            } else {
                echo json_encode(['success' => false, 'message' => '이미 선택하셨습니다.']);
                exit;
            }
        } else {
            // 좋아요나 싫어요 추가
            if ($likeAction === 'like') {
                $sql = "UPDATE teamBoard SET boardLike = boardLike + 1 WHERE boardId = '$boardId'";
            } elseif ($likeAction === 'dislike') {
                $sql = "UPDATE teamBoard SET boardDislike = boardDislike + 1 WHERE boardId = '$boardId'";
            }

            // 사용자의 선택을 데이터베이스에 저장
            $insertSql = "INSERT INTO teamLikes (memberId, boardId, likeAction) VALUES ('$memberId', '$boardId', '$likeAction')";
            $connect->query($insertSql);
        }

        if (!empty($sql)) {
            if ($connect->query($sql)) {
                // 좋아요 및 싫어요 수를 가져옴
                $countSql = "SELECT boardLike, boardDislike FROM teamBoard WHERE boardId = '$boardId'";
                $countResult = $connect->query($countSql);
                $countData = $countResult->fetch_assoc();

                $response = [
                    'success' => true,
                    'likeCount' => $countData['boardLike'],
                    'dislikeCount' => $countData['boardDislike']
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'SQL 오류: ' 
                ];
                echo json_encode($response);
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
        exit;
    }
} else {
    $response = [
        'success' => false,
        'message' => '요청에 필요한 데이터가 없습니다.'
    ];
    echo json_encode($response);
}
?>
