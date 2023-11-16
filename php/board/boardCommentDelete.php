<?php
    include "../connect/connect.php";

    $commentPass = $_POST['commentPass'];
    $commentId = $_POST['commentId'];

    $sql = "SELECT commentPass FROM boardComment WHERE commentPass = '$commentPass' AND commentId = '$commentId'";
    $result = $connect -> query($sql);

    if($result -> num_rows == 0){
        $jsonResult = "bad";
    } else {
        // $updateSql = "DELETE FROM boardComment WHERE commentId = '$commentId'"; 완전지울때
        $updateSql = "UPDATE boardComment SET commentDelete = '0' WHERE commentId = '$commentId'";
        $connect -> query($updateSql);
        $jsonResult = "good";
    }
    echo json_encode(array("result" => $jsonResult));
?>