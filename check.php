<?php
    if (isset($_POST['name']) ? $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : $name = '');
    if (isset($_POST['password']) ? $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8') : $password = '');

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //select文の準備
    $stmt = $dbh->prepare('SELECT * FROM admins WHERE(
        name = :name
    )');
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $pass = $stmt->fetch();

    if (password_verify($password, $pass['password_hash'])) {
        //セッションに保存
        session_start();
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_name'] = $name;

        //index.phpに飛ぶ
        header('Location:index.php');
    } else {
        //ログイン画面に戻る
        header('Location:login.php');
    }
