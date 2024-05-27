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

//ログアウト処理が出来たらログ画面へ遷移
if (!isset($_SESSION["login"])) {
    header("Location: ./Login.php");
}