<?php

    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    if (isset($_GET['id']) ? $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8') : $id = '');

    //DBへのINSERT
    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //SELECT文準備
    $stmt = $dbh->prepare('SELECT * FROM contacts WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $contact = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple Form</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">お問い合わせ</a></li>
                <li><a href="logout.php">ログアウト</a></li>
            </ul>
        </nav>
        <main>
            <section>
                <h2>管理画面　お問い合わせ詳細</h2>
                <div class="list">
                <table>
                    <tbody>
                        <tr>
                            <th>id</th><td><?php echo $contact['id']; ?></td>
                        </tr>
                        <tr>
                            <th>名前</th><td><?php echo $contact['name']; ?></td>
                        </tr>
                        <tr>
                            <th>email</th><td><?php echo $contact['email']; ?></td>
                        </tr>
                        <tr>
                            <th>性別</th><td><?php echo $contact['gender']; ?></td>
                        </tr>
                        <tr>
                            <th>お問い合わせ内容</th><td><?php echo $contact['message']; ?></td>
                        </tr>
                        <tr>
                            <th>受付日時</th><td><?php echo $contact['created']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><a href="index.php"><button class="btn btn-primary">一覧へ戻る</button></a></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>
        </main>
        <footer>
            &copy; 20xx Sample corporation.
        </footer>
    </body>
</html> 