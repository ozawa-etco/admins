<?php
    session_start();
    $_SESSION['admin_login'] = false;

    //ログ
    $admin_name = $_SESSION['admin_name'];
    $fp = fopen('log.txt', 'a');
    fwrite($fp, date('Y-m-d H:i:s').": logout!($admin_name)\n");
    fclose($fp);

    header('location:login.php');
