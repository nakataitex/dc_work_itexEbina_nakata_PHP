<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=xb513874_u338x';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
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


    $_SESSION["test"] = "test";
    $_SESSION['count'] = 0;

    if (isset($_POST["user_name"]) && isset($_POST["pass"])):
        var_dump($_POST["user_name"]);
        var_dump($_POST["pass"]);

        try {
            $db = new PDO($dsn, $login_user, $password);
            echo "接続完了";
            $idcheck = 'SELECT user_name,password FROM user_table WHERE user_name = :user_name AND password = :pass;';
            $stmt = $db->prepare($idcheck);
            $user_name = $_POST['user_name']; //入力したID
            $user_password = $_POST['pass']; //入力したパス
            $stmt->bindparam(':user_name', $user_name);
            $stmt->bindparam(':pass', $user_password);
            //SQL実行
            $stmt->execute();

            //認証結果取得
            $result = $stmt->fetch(PDO::FETCH_NUM);

            if ($result || $_COOKIE["user_name"]):
                if (isset($_POST['cookie_confirmation']) === TRUE) {
                    $cookie_confirmation = "checked";
                } else {
                    $cookie_confirmation = "";
                }
                // ログインIDの入力省略にチェックがされている場合はCookieを保存
                if ($cookie_confirmation === 'checked') {
                    //Cookieの保存期間
                    define('EXPIRATION_PERIOD', 30);
                    $cookie_expiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;
                    setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
                    setcookie('user_name', $user_name, $cookie_expiration);
                    $_SESSION["user_name"] = $user_name;
                } else {
                    // チェックされていない場合はCookieを削除する
                    setcookie('cookie_confirmation', '', time() - 30);
                    setcookie('user_name', '', time() - 30);
                }
            else: //ない場合
                throw new PDOException('結果が見つかりませんでした。');
            endif;
        } catch (PDOException $e) {
            echo $e->getMessage();
            header("location: ./login.php");
            exit();
        }
    endif;

    // ログイン中のユーザーであるかを確認する
    if (isset($_SESSION["user_name"]) && isset($_COOKIE["user_name"])) {
    echo '[セッション + クッキー]ようこそ' . htmlspecialchars($_SESSION['user_name']) . 'さん';
    } elseif (isset($_SESSION["user_name"])) {
        echo '[セッション]ようこそ' . htmlspecialchars($_SESSION['user_name']) . 'さん';
    } elseif (isset($_COOKIE["user_name"])) {
        echo '[クッキー]ようこそ' . htmlspecialchars($_COOKIE['user_name']) . 'さん';
    } else {
        // ログイン中ではない場合は、try55.phpにリダイレクト（転送）する
        header("location: ./login.php");
        exit();
    }
    ?>

    <a href="./logout.php">ログアウト</a>
</body>

</html>