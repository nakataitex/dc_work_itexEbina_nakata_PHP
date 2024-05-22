<?php
session_start();//セッションスタート
if (isset($_SESSION["login"]) && isset($_SESSION["user_name"])) {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
    header("Location: ./index.php");//ログインしている場合トップページへ移動
    exit();
}
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';


if (isset($_SESSION["form"])) {
    $form = $_SESSION["form"];
} else {
    header("Location: ./ec_register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    date_default_timezone_set("Asia/Tokyo");
    $date = date("Y-m-d");
    $insert_user = "INSERT INTO ec_user_table(user_name, password, create_date) VALUES(:user_name, :password, :create_date)";
    $password = password_hash($form["password"], PASSWORD_DEFAULT);
    $insert_data = [
        ":user_name" => h($form["name"]),
        ":password" => $password,
        ":create_date" => current_date()
    ];
    $insert_result = sql_fetch_data($insert_user, $insert_data);
    var_dump($insert_result);
    if ($insert_result) {
        unset($_SESSION["form"]);
        header("Location: ./ec_registration_complete.php");
    }
}


require_once ('../../include/view/ec_register_check_view.php');