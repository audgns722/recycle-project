<?php
    $host = "localhost";
    $user = "audgns722";
    $pw = "dkrak221!!";
    $db = "audgns722";

    $connect = new mysqli($host, $user, $pw, $db);
    $connect -> set_charset("utf-8");

    // if(mysqli_connect_errno()){
    //     echo "DATABASE Connect False";
    // } else {
    //     echo "DATABASE Connect True";
    // }
?>