<?php
session_start();
if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
    $form = $_SESSION["product"];
} else {
    header("Location: ./ec_login.php");//管理者以外はログインページへ移動、ログインしてる場合はその後index.phpに移動
    exit();
}
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/ec_model.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/ec_product_manage_model.php';

$pdo = get_connection();//接続
$message = [];
//フォーム情報の初期化
if (isset($_SESSION['product']) && $_SESSION["product"] !== "") {
    $product = $_SESSION['product'];
} else {
    $product = [
        "product_name" => "",
        "price" => "",
        "stock_qty" => "",
        "image_name" => "",
        "public_flg" => "",
        "create_date" => "",
        "product_id" => "",
    ];
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["entry"]))
        $product = h($_SESSION["product"]);
    $pdo->beginTransaction();
    if (insert_product($pdo, $product)) {
        $product["product_id"] = $pdo->lastInsertId();
        insert_image($pdo, $product);
        insert_stock($pdo, $product);
        $message["normal"]["product_manage"][] = "add_product";
        $pdo->commit();
        $session["form"] = $form;
        header("Location: ./ec_product_manage.php");
    } else {
        $message["error"]["db"][] = "db_error";
        $pdo->rollBack();
    }
}
include_once "../../include/view/ec_add_product_check_view.php";