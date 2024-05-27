<?php
session_start();
if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] !== "ec_admin") {
    header("Location: ./Catalog.php");//一般ユーザーの場合商品一覧ページへ移動
    exit();
} elseif ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
    header("Location: ./Manage.php");//管理者の場合商品管理ページへ移動
} else {
    header("Location: ./Login.php");//ログインしてない場合ログインページへ移動
    exit();
}