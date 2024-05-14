<?php
//定数(const.php)を読み込む
require_once 'const.php';

//Model(model.php)を読み込む
require_once 'ec_product_model.php';

$product_data = [];//商品データ
$pdo = get_connection();//接続
$product_data = get_product_list($pdo);
$product_view_data = h_array($product_data);

//コントローラ
//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") { //ポストがあった時に動作
    //名前チェック
    $form["name"] = h($_POST["name"]);
    $error["name"] = validation($form["name"],5);
    var_dump($error["name"]);

    //パスワードチェック
    $form["password"] = h($_POST["password"]);
    $error["password"] = validation($form["password"],8);
    var_dump($error["password"]);

    //エラーがない時
    if (empty($error)) {
        $_SESSION["form"] = $form;
        header("Location: check.php");
        exit();
    }
}

//view(view.php)読み込み これはテスト表示用
// include_once 'ec_product_list_view.php'; 
 
 
//会員登録画面
include_once "register.php"; 