<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/common_model.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/catalog_model.php';

session_start();
commonUserCheck();

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();
$action = $_POST["action"] ?? "";

//カートに追加
if ($action === "add") {
    $error_message = addCart($error_message);
    if (empty($error_message)) {
        $message = "カートに追加しました";
    }
}

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";
$catalog_data = getCatalog() ?? "";
$array_catalog_data = convertToArray($catalog_data) ?? "";
$catalog_view_data = h_array($array_catalog_data) ?? "";

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "商品一覧";
//ページリンク
$menus = [
    "./cart.php" => "カート",
    "./ogout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/header_view.php";
include_once "../../include/view/catalog_view.php";
include_once "../../include/view/footer_view.php";