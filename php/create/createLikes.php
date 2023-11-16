<?php
    include "../connect/connect.php";

    $sql = "CREATE TABLE teamLikes(";
    $sql .= "likesId int(10) unsigned auto_increment,";
    $sql .= "memberId int(10) unsigned NOT NULL,";
    $sql .= "boardId int(10) unsigned NOT NULL,";
    $sql .= "likeAction ENUM('like', 'dislike') NOT NULL,";
    $sql .= "PRIMARY KEY(likesId)";
    $sql .= ") charset=utf8";

    $connect -> query($sql);
?>