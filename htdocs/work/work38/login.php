<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work38</title>
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
    // バリデーション
    if (isset($_POST['user_name']) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['user_name'])) {
        $user_name = $_POST['user_name'];
        $_SESSION['user_name'] =  $user_name;
    } else {
        $user_name = '';
        $_SESSION['err_flg'] = true;
    }
    ?>

    <form action="home.php" method="post">
        ユーザーネーム:<input type="text" name="user_name" value="<?php print $user_name; ?>">
        パスワード:<input type="password" name="pass"><br>
        <input type="checkbox" name="cookie_confirmation"
            value="<?php print $cookie_confirmation; ?>">次回からログインIDを省略する<br>
        <input type="submit" value="ログイン">
    </form>


</body>

</html>