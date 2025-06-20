<?php
    session_start();

    $host = "MySQL-8.2";
    $user = "root";
    $password = "";
    $namebass = "homeworkphp";
    $login = "root";
    $password = "";
    $connect = new mysqli($host, $user, $password, $namebass);

    if($connect->connect_error) {
        die("Ошибка подключения" . $connect->connect_error);
    }

    $result = $connect->query("SELECT * FROM bank");
    $infobank = $result->fetch_all(MYSQLI_ASSOC);
    
    $result5 = $connect->query("SELECT * FROM bankomat");
    $allbankomat = $result5->fetch_all(MYSQLI_ASSOC);
    
    $result4 = $connect->query("SELECT * FROM client");
    $allclient = $result4->fetch_all(MYSQLI_ASSOC);

    $result5 = $connect->query("SELECT * FROM users");
    $allusers = $result5->fetch_all(MYSQLI_ASSOC);
?>