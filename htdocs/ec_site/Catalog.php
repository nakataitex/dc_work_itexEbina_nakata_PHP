<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/CommonModel.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/CatalogModel.php';

session_start();
commonUserCheck();

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();
$action = $_POST["action"] ?? "";

//カートに追加
if ($action === "add") {
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $error_message = addCart($error_message);
        if (empty($error_message)) {
            $pdo->commit();
            $message[] = "商品をカートに追加しました";
        } else {
            $pdo->rollBack();
        }
    } catch (PDOException $e) {
        $error_message[] = $e->getMessage();
        $pdo->rollBack();
    }
}

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";
$catalog_data = getCatalog() ?? "";
$array_catalog_data = convertToArray($catalog_data) ?? "";
$catalog_view_data = h_array($array_catalog_data) ?? "";

//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "商品一覧";
//ページリンク
$menus = [
    "./Cart.php" => "カート",
    "./Logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/CatalogView.php";
include_once "../../include/view/FooterView.php";