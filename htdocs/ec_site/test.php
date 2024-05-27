<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';

//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';


session_start();//セッションスタート
$pdo = get_connection();//接続

//test情報
    $form = [
        "name" => "12345",
        "password" => "12345"
    ];

$message = [];


//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 名前チェック
    $form["name"] = h($_POST["name"]);
    $message["name"] = validation_user_password($form["name"], 5);

    $name_count_sql = "SELECT count(*) cnt from ec_user_table where user_name = :user_name";
    $name_param = [
        ":user_name" => $form["name"]
    ];
    $name_count = sql_fetch_data($name_count_sql, $name_param);
    $message["name"] = duplicate_check($name_count, $message["name"]);

    // パスワードチェック
    $form["password"] = h($_POST["password"]);
    $message["password"] = validation_user_password($form["password"], 8);

    // エラーがない時
    if (empty($message["name"]) && empty($message["password"])) {
        $_SESSION["form"] = $form;
        header("Location: ec_check.php");
        exit();
    }
}



//会員登録画面を表示
include_once "../../include/view/ec_register_view.php";