<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/CommonModel.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/CartModel.php';

session_start();
commonUserCheck();

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();
$action = $_POST["action"] ?? "";
$cart_data = getCart() ?? "";

//注文
if ($action === "buy") {
    try {
        $order_id = order($cart_data, $error_message);
        if ($order_id) {
            $_SESSION["order_id"] = $order_id;
            header("Location: ./Purchase.php");
            exit();
        }
    } catch (Exception $e) {
        $error_message[] = $e->getMessage();
    }
}
//削除
if ($action === "delete") {
    if (isset($_POST["product_id"])) {
        $error_message = deleteFromCart($error_message);
        if (empty($error_message)) {
            $message[] = "カートから削除しました";
        }
    }
}
//数量変更
if ($action === "update_qty") {
    if (isset($_POST["product_id"]) && isset($_POST["product_qty"]) && (int) $_POST["product_qty"] > 0) {
        $error_message = updateQtyFromCart($error_message);
        if (empty($error_message)) {
            $message[] = "個数を変更しました";
        }
    } else {
        $error_message[] = "数量は1以上の整数を指定してください";
    }
}

$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$cart_data = getCart() ?? "";
$array_cart_data = convertToArray($cart_data) ?? [];
$cart_view_data = h_array($array_cart_data) ?? [];
if (empty($cart_data)) {
    $error_message[] = "カートに何も入っていません";
}

//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "カート";
//ページリンク
$menus = [
    "./Catalog.php" => "商品一覧",
    "./Logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/CartView.php";
include_once "../../include/view/FooterView.php";