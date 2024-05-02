<?php
//セッション開始（エラーがあればエラーメッセージ表示）
session_start();


//ログイン中ならhome.phpに移動
if (isset($_SESSION['user_name'])):
    header('Location:home.php');
    exit();
endif;

//cookieに値がある場合、変数に格納する
if (isset($_COOKIE['cookie_confirmation']) === TRUE) {
    $cookie_confirmation = "checked";
} else {
    $cookie_confirmation = "";
}
if (isset($_COOKIE['user_name']) === TRUE) {
    $user_name = $_COOKIE['user_name'];
} else {
    $user_name = '';
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work37</title>
</head>

<body>
    <?php
    if (isset($_SESSION['err_flg']) && $_SESSION['err_flg'] === True):
        echo "<p>ログインに失敗しました。正しいIDとパスワードを入力してください。</p>";
    endif;

    //メッセージ表示後、エラーフラグをfalseに
    $_SESSION['err_flg'] = False;
    ?>

    <form action="home.php" method="post">
        ユーザーネーム:<input type="text" name="user_name" value="<?php print $user_name; ?>">
        パスワード:<input type="text" name="pass">
        <input type="checkbox" name="cookie_confirmation" value="checked" <?php print $cookie_confirmation; ?>>次回からログインIDを省略する<br>
        <input type="submit" value="ログイン">
    </form>
</body>

</html>