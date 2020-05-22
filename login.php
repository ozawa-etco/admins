<?php
    if (isset($_POST['name']) ? $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : $name = '');
    if (isset($_POST['password']) ? $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'utf-8') : $password = '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section class="form-section">
            <h2>ログイン</h2>
            <div class="form-container">
                <form id="form" action="check.php" method="post">
                    <div class="form-group">
                        <label>氏名</label>
                        <input type="text" name="name" id="name" class="form-item" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-item" value="<?php echo $password; ?>">
                    </div>

                    <div class="form-group login">
                        <button type="submit" class="btn btn-primary">ログイン</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html> 