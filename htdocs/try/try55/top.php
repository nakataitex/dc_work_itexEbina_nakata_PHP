<?php
//セッション開始
session_start();
//cookie保存期間
define("EXPIRATION_PERIOD", 30);
$cookie_expiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;

//POSTされたフォームの値を変数に格納する
if ($_SERVER["REQUEST_METHOD"] === "POST"):
    if (isset($_POST['cookie_confirmation'])):
        $cookie_confirmation = $_POST["cookie_confirmation"];
    else:
        $cookie_confirmation = "";
    endif;
    if (isset($_POST["login_id"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST['login_id'])):
        $login_id = $_POST['login_id'];
        $_SESSION['login_id'] = $login_id;
    else:
        $login_id = "";
        $_SESSION["err_flg"] = true;


    endif;
endif;

//ユーザー名の保存チェックされてる場合はcookieを保存
if($cookie_confirmation === "checked"):
    setcookie("cookie_confirmation",$cookie_confirmation,$cookie_expiration);
    setcookie("login_id",$login_id,$cookie_expiration);
else:
    //チェックされていない場合はcookieを削除する
    setcookie("cookie_confirmation", "",time()-30);
    setcookie("login_id","",time()-30);
endif;

//ログイン中のユーザであるか確認
if(!isset($_SESSION["login_id"])):
    //ログイン中ではない場合は、try55.phpにリダイレクト(転送)
    header('Location: try55.php');
    exit();
else:
    echo "<p>".$_SESSION["login_id"]."さん：ログイン中です</p>";
endif;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="try55.php" method = "post">
        <input type="hidden" name="logout" value ="logout">
        <input type="submit" value = "ログアウト">
    </form>
</body>
</html>