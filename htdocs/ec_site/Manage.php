<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/CommonModel.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/ManageModel.php';

session_start();
adminCheck();
/* $product_data = [];//商品データ */
$message = [];
$error_message = [];
$pdo = getConnection();
$action = $_POST["action"] ?? "";
$product_name = isset($post['product_name']) ? $post['product_name'] : '';
$price = isset($post['price']) ? $post['price'] : 0;
$public_flg = isset($post['public_flg']) ? $post['public_flg'] : 0;
$image = isset($post['image']) ? $post['image'] : '';


//追加
if ($action === "add") {
    if (isset($_POST["product_name"]) && isset($_POST["price"]) && isset($_POST["stock_qty"]) && $_POST["stock_qty"] >= 0 && isset($_FILES["image"]) && isset($_POST["public_flg"])) {
        $error_message = addProductManage($error_message);
        if (empty($error_message)) {
            $message[] = "商品の追加に成功しました";
        }
    }
}
//切り替え
if ($action === "toggle") {
    $error_message = togglePublicManage($error_message);
    if (empty($error_message)) {
        $message[] = "商品の公開ステータスを切り替えました";
    }
}

//削除
if ($action === "delete") {
    $error_message = deleteProductManage($error_message);
    if (empty($error_message)) {
        $message[] = "商品を削除しました";
    }
}

//数量変更
if ($action === "update_qty") {
    if (isset($_POST["product_id"]) && isset($_POST["stock_qty"]) && $_POST["stock_qty"] >= 0) {
        $error_message = updateQty($error_message);
    }
    if (empty($error_message)) {
        $message[] = "数量の変更に成功しました";
    }
}

$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$product_data = getProducts() ?? "";
$array_product_data = convertToArray($product_data) ?? [];
$product_view_data = h_array($array_product_data) ?? [];


//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "商品管理";
//ページリンク
$menus = [
    "./Logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/ManageView.php";
include_once "../../include/view/FooterView.php";