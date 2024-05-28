<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(CommonModel.php)を読み込む
require_once '../../include/model/CommonModel.php';
//Model(CartModel.php)を読み込む
require_once '../../include/model/PurchaseModel.php';

session_start();
commonUserCheck();
var_dump($_SESSION);
$message = [];
$error_message = [];
$user_id = $_SESSION["user_id"];
/* $order_id = $_SESSION["order_id"]; */
$pdo = getConnection();
$order_data = getOrderDetails($pdo) ?? "";

if (empty($order_data)) {
    $error_message[] =  "注文情報が見つかりません。";
    exit();
}


$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$array_order_data = convertToArray($order_data) ?? [];
$order_view_data = h_array($array_order_data) ?? [];


//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "購入完了";
//ページリンク
$menus = [
    "./Catalog.php" => "商品一覧",
    "./Logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/PurchaseView.php";
include_once "../../include/view/FooterView.php";
