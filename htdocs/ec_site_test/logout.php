<?php
session_start();

$params = [//ログアウトしたセッション情報
    "login",
    "user_id",
    "user_name",
    "order_id",
    "success"
];

//セッション情報をまとめてunsetする
foreach ($params as $param) {
    if ($_SESSION[$param]) {
        unset($_SESSION[$param]);
    }
}

//ログアウト処理が出来たらログイン画面へ遷移
if (!isset($_SESSION["login"])) {
    header("Location: ./index.php");
}
