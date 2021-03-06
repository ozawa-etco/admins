<?php

    session_start();
    if ($_SESSION['admin_login'] == false) {
        header('Location:login.php');
        exit;
    }

    $id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'utf-8') : '';

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
                            <th>最終更新日時</th><td><?php echo $contact['updated']; ?></td>
                        </tr>
                        <tr>
                            <th>処理</th>
                            <td>
                                <?php if ($contact['processed'] == 0): ?>
                                    未処理
                                <?php else: ?>
                                    処理済
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="index.php"><button class="btn btn-primary">一覧へ戻る</button></a>
                                <a href="edit.php?id=<?php echo $contact['id']; ?>"><button class="btn btn-info">編集</button></a>
                                <button class="delete btn btn-danger" data-id="<?php echo $contact['id']; ?>">削除</button>
                                <form method="POST" action="delete.php" id="delete_form_<?php echo $contact['id']; ?>">
                                    <input type="hidden" value="<?php echo $contact['id']; ?>" name="id">
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </section>
        </main>
        <footer>
            &copy; 20xx Sample corporation.
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(".delete").click(function(){
                var id = this.dataset.id;
                if(confirm("ID:"+id+"番のお問い合わせを本当に削除していいですか？")){
                    //OK
                    $("#delete_form_"+id).submit();
                }else{
                    //キャンセル
                    return false;
                }
            })
        </script>
    </body>
</html> 