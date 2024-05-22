<?php
session_start();
if ($_SESSION["login"] && isset($_SESSION["user_name"])) {
    header("Location: ./ec_top.php");//ログインしてる場合トップページへ移動
    exit();
} else {
    header("Location: ./ec_login.php");//ログインしてない場合ログインページへ移動
    exit();
}