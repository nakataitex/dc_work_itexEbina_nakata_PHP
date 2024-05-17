<?php
session_start();
require_once ("../../include/config/const.php");//定数
require_once ("../../include/model/ec_model.php");//model

if ($_SESSION["login"] && $_SESION["user_name"] !== "ec_admin") {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
} else {
    header("Location: ec_login.php");//ログイン出来ていなかったらログインページへ移動
    exit();
}


echo "ようこそ $user さん<br>";
echo "ユーザーID: $id<br>";
echo "ユーザー名: $user";


include_once ("../../include/view/ec_top_view.php");