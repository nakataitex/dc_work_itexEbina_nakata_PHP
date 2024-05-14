<?php
//定数(const.php)を読み込む
require_once '../../../include/config/const.php';

//共通のModel(model.php)を読み込む
require_once '../../../include/model/ec_model.php';

//ユーザー登録画面のModel(ec_register_model.php)を読み込む
require_once '../../../include/model/ec_register_model.php';

$pdo = get_connection();//接続

//セッションに使用する
$form = [
    "name" => "",
    "password" => ""
];
$error = [];

//コントローラ
//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") { 
    //名前チェック
    $form["name"] = h($_POST["name"]);
    $error["name"] = validation($form["name"],5);

    //パスワードチェック
    $form["password"] = h($_POST["password"]);
    $error["password"] = validation($form["password"],8);

    //var_dump($error);

    //エラーがない時
    if (empty($error)) {
        $_SESSION["form"] = $form;
        header("Location: check.php");
        exit();
    }
}
 
 
//会員登録画面を表示
include_once "../../../include/view/register_view.php"; 