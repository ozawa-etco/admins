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
                        <form class="search" action="index.php" method="GET">
                            <input type="text" name="keyword" placeholder="名前検索" value="<?php echo $keyword; ?>">
                            <button type="submit" class="btn btn-primary" >検索</button>
                        </form>
                    </div>
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>名前</th>
                            <th>メールアドレス</th>
                            <th>受付日時</th>
                            <th>処理状況</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><a href="show.php?id=<?php echo $contact['id']; ?>"><?php echo $contact['id']; ?></td>
                            <td><?php echo $contact['name']; ?></td>
                            <td><?php echo $contact['email']; ?></td>
                            <td><?php echo $contact['created']; ?></td>
                            <td><?php if ($contact['processed'] == 0): ?><span style="color:red">未処理</span><?php else: ?><span style="color:green">処理済</span><?php endif; ?></td>
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