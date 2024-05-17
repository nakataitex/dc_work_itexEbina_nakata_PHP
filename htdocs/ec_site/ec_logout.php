<?php
session_start();

$params = [//ログアウトしたセッション情報
    "login",
    "user_id",
    "user_name"
];

//まとめてunsetする
foreach ($params as $param) {
    if ($_SESSION[$param]) {
        unset($_SESSION[$param]);
    }
}


if(!isset($_SESSION["login"])){
    header("Location: ec_login.php");
}