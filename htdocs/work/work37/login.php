<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work37</title>
</head>

<body>
    <?php
    //cookieに値がある場合、変数に格納する
    if (isset($_COOKIE['cookie_confirmation']) === TRUE) {
        $cookie_confirmation = "checked";
    } else {
        $cookie_confirmation = "";
    }
    if (isset($_COOKIE["user_name"]) === TRUE) {
        $user_name = $_COOKIE["user_name"];
    } else {
        $user_name = "";
    }
    ?>

    <form action="home.php" method="post">
        ユーザーネーム:<input type="text" name="user_name" value="<?php print $user_name; ?>">
        パスワード:<input type="password" name="pass">
        <input type="checkbox" name="cookie_confirmation" value="checked">次回からログインIDを省略する<br>
        <input type="submit" value="ログイン">
    </form>

    
</body>

</html>