<?php
session_start();
if ($_SESSION["login"] && isset($_SESSION["user_name"]) &&$_SESSION["user_name"] === "ec_admin") {
    header("Location: ./ec_product_manage.php");
}elseif ($_SESSION["login"] && isset($_SESSION["user_name"])) {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
} else {
    header("Location: ./ec_login.php");//ログイン出来ていなかったらログインページへ移動
    exit();
}

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';

//テストメッセージ
echo "ようこそ $user さん<br>";
echo "ユーザーID: $id<br>";
echo "ユーザー名: $user";

//トップ画面のViewを読み込む
include_once ("../../include/view/ec_top_view.php");