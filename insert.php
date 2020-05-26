<?php

    if (isset($_POST['name']) ? $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : $name = '');
    if (isset($_POST['email']) ? $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8') : $email = '');
    if (isset($_POST['gender']) ? $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8') : $gender = '');
    if (isset($_POST['message']) ? $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'utf-8') : $message = '');

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $stmt = $dbh->prepare('insert into contacts(
        name,
        email,
        gender,
        message
    ) values(
        :name,
        :email,
        :gender,
        :message
    )');
    //bindParamで各パラメータにconfirm.phpから取得した値を代入する
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':message', $message);
    //insertを実行
    $stmt->execute();

    header('Location:index.php');
