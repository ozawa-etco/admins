<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    if (isset($_POST['id']) ? $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8') : $id = '');
    if (isset($_POST['name']) ? $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : $name = '');
    if (isset($_POST['email']) ? $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8') : $email = '');
    if (isset($_POST['gender']) ? $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8') : $gender = '');
    if (isset($_POST['message']) ? $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'utf-8') : $message = '');
    if (isset($_POST['processed']) ? $processed = htmlspecialchars($_POST['processed'], ENT_QUOTES, 'utf-8') : $processed = '');

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $dbh->prepare('UPDATE contacts SET
        name = :name,
        email = :email,
        gender = :gender,
        message = :message,
        processed = :processed,
        updated = now() 
        WHERE 
        id = :id');
    //bindParamで各パラメータにconfirm.phpから取得した値を代入する
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':processed', $processed);
    $stmt->bindParam(':id', $id);
    //insertを実行
    $stmt->execute();

    header('Location:index.php');
