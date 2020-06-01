<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8') : '';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8') : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender'], ENT_QUOTES, 'utf-8') : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'utf-8') : '';
    $processed = isset($_POST['processed']) ? htmlspecialchars($_POST['processed'], ENT_QUOTES, 'utf-8') : '';

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

    //ログ
    $admin_name = $_SESSION['admin_name'];
    $fp = fopen('log.txt', 'a');
    fwrite($fp, date('Y-m-d H:i:s').": ID:$id was edited.(by $admin_name)\n");
    fclose($fp);

    header('Location:index.php');
