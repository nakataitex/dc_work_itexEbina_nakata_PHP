<?php
//定数(const.php)を読み込む
require_once "../../include/config/const.php";
//Modelを読み込む
require_once "../../include/model/common_model.php";
require_once "../../include/model/manage_model.php";

session_start();
adminCheck();
$message = [];
$error_message = [];
$pdo = getConnection();
$product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : "";
$price = isset($_POST["price"]) ? $_POST["price"] : 0;
$public_flg = isset($_POST["public_flg"]) ? $_POST["public_flg"] : 0;
$image = isset($_POST["image"]) ? $_POST["image"] : "";
$action = $_POST["action"] ?? "";

//追加
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($action === "add") {
        try {
            validationAddProduct($pdo);
            $message[] = addProductToDatabase($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
    //切り替え
    if ($action === "toggle") {
        try {
            $message = togglePublicManage($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
    //削除
    if ($action === "delete") {
        try {
            $message = deleteProductManage($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
    //数量変更
    if ($action === "update_qty") {
        try {
            manageIntValidation();
            $message = updateQty($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
}
$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$product_data = getProducts() ?? "";
$array_product_data = convertToArray($product_data) ?? [];
$product_view_data = hArray($array_product_data) ?? [];

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "商品管理";
//ページリンク
$menus = [
    "./logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/view/header_view.php";
include_once "../../include/view/manage_view.php";
include_once "../../include/view/footer_view.php";