<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
    <h1>ログイン</h1>
    <form action="home.php" method="POST">
        ID:<input type="text" name="id" value="<?php print $cookie_check["login_id"]; ?>"><br>
        PASS:<input type="text" name="pass"><br>
        次回からログインIDの入力を省略<input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation;?>><br>
        <input type="submit" value="送信">
    </form>
</body>
</html>