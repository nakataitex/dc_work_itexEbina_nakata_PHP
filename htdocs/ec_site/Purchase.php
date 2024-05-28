<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(common_model.php)を読み込む
require_once '../../include/model/common_model.php';
//Model(cart_model.php)を読み込む
require_once '../../include/model/purchase_model.php';

session_start();
commonUserCheck();

$message = [];
$error_message = [];
$user_id = $_SESSION["user_id"];
$order_id = $_SESSION["order_id"] ?? "";
$error_message = sessionOrderIdCheck($error_message);

if (!empty($order_id)) {
    $pdo = getConnection();
    $order_data = getOrderDetails($pdo) ?? "";
    $display_message = convertToArray($message) ?? [];
    $total_amount = getTotalAmount() ?? [];
    $array_order_data = convertToArray($order_data) ?? [];
    $order_view_data = h_array($array_order_data) ?? [];
}
$display_error_message = convertToArray($error_message) ?? [];

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "購入完了";
//ページリンク
$menus = [
    "./catalog.php" => "商品一覧",
    "./logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/header_view.php";
include_once "../../include/view/purchase_view.php";
include_once "../../include/view/footer_view.php";
