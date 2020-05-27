<?php
    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    //PDOを使ってDBに接続
    $dbh = new PDO('mysql:host=localhost;dbname=sample_1_6_db', 'root', 'root');
    //エラーがある場合に表示させる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    //select文作成
    $stmt = $dbh->prepare('SELECT * FROM contacts');
    $stmt->execute();
    //結果を$contactsに格納
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <h2>管理画面トップページ</h2>
                <div class="list">
                    <div class="list-box">
                        <a href="create.php"><button class="btn btn-primary">新規作成</button></a>
                    </div>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>受付日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><a href="show.php?id=<?php echo $contact['id']; ?>"><?php echo $contact['id']; ?></td>
                            <td><?php echo $contact['name']; ?></td>
                            <td><?php echo $contact['email']; ?></td>
                            <td><?php echo $contact['created']; ?></td>
                        </tr>
                        <?php endforeach; ?>
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