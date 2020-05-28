<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'utf-8') : '';

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //select文作成
    if ($keyword == '') {
        $stmt = $dbh->prepare('SELECT * FROM contacts');
    } else {
        $stmt = $dbh->prepare('SELECT * FROM contacts WHERE name like :keyword');
        $stmt->bindValue(':keyword', '%'.$keyword.'%');
    }
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //contacts.csvに書き込む準備（書き出しのみでファイルをオープンする）
    $fp = fopen('contacts.csv', 'w');

    //BOMあり（文字化け対応）
    fwrite($fp, "\xEF\xBB\xBF");

    //ヘッダーを設定
    $header = ['ID', '名前', 'メールアドレス', '性別', 'お問い合わせ内容', '受付日時', '処理', '更新日時'];

    //ヘッダーをcontacts.csvに書き込み
    fputcsv($fp, $header);

    //1レコードずつループしてcontacts.csvに書き込み
    foreach ($contacts as $contact) {
        fputcsv($fp, $contact);
    }

    //ファイルを閉じる
    fclose($fp);

    //作成したcsvにアクセス（DL）
    header('Location:contacts.csv');
