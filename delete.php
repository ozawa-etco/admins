<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id'], ENT_QUOTES, 'utf-8') : '';

    //DB接続
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    } catch (PDOException $e) {
        var_dump($e->getMessage());
        exit;
    }

    $stmt = $dbh->prepare('DELETE FROM contacts WHERE id=:id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('location:index.php');
