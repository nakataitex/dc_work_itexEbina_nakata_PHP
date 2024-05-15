<?php
//定数(const.php)を読み込む
require_once '../../../include/config/const.php';

//共通のModel(model.php)を読み込む
require_once '../../../include/model/ec_model.php';

//ユーザー登録画面のModel(ec_register_model.php)を読み込む
require_once '../../../include/model/ec_register_model.php';

session_start();//セッションスタート
$pdo = get_connection();//接続

//フォームの内容があれば復元
if (isset($_GET["action"]) && $_GET["action"] === "rewrite" && isset($_SESSION["form"])) {
    $form = $_SESSION["form"];
} else {
    //セッションの情報を初期化
    $form = [
        "name" => "",
        "password" => ""
    ];
}
$error = [];


//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //名前チェック
    $form["name"] = h($_POST["name"]);
    $error["name"] = validation($form["name"], 5);
    $name_count_sql = "SELECT count(*) cnt from ec_user_table where user_name = :user_name";
    $name_param = [
        ":user_name" => $form["name"]
    ];
    $name_count = sql_fetch_data($name_count_sql, $name_param);
    $error["name"] = duplicate_check($name_count,$error["name"]);

    //パスワードチェック
    $form["password"] = h($_POST["password"]);
    $error["password"] = validation($form["password"], 8);

    var_dump($error);

    //エラーがない時
    if (empty($error["name"] && empty($error["password"]))) {
        $_SESSION["form"] = $form;
        header("Location: ec_check.php");
        exit();
    }
}



//会員登録画面を表示
include_once "../../../include/view/ec_register_view.php";