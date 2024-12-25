<?php
//定数を読み込む
require_once '../../include/test/config/const.php';
//Modelを読み込む
require_once '../../include/test/model/common_model.php';
require_once '../../include/test/model/purchase_model.php';

session_start();
commonUserCheck();

$message = [];
$error_message = [];
$user_id = $_SESSION["user_id"];
$order_id = $_SESSION["order_id"] ?? "";
$order_data = [];
try {
    if (!empty($order_id)) {
        $pdo = getConnection();
        sessionOrderIdCheck();
        $total_amount = getTotalAmountSql() ?? [];
        $order_data = getOrderDetails($pdo);
    }
} catch (Exception $e) {
    $error_message[] = $e->getMessage();
}

$display_message = convertToArray($message) ?? [];
$display_error_message = convertToArray($error_message) ?? [];
$array_order_data = convertToArray($order_data) ?? [];
$order_view_data = hArray($array_order_data) ?? [];

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
include_once "../../include/test/view/header_view.php";
include_once "../../include/test/view/purchase_view.php";
include_once "../../include/test/view/footer_view.php";
