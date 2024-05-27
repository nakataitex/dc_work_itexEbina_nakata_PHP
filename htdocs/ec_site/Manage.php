<?php
//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/CommonModel.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/ManageModel.php';

session_start();
adminCheck();

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();
$action = $_POST["action"] ?? "";

//追加
if ($action === "add") {
    try {
        $pdo->beginTransaction();
        $error_message = validationAddProduct($pdo, $error_message);
        if (empty($error_message)) {
            $error_message = addProduct($pdo, $error_message);
            if (empty($error_message)) {
                $pdo->commit();
                $message[] = "商品を追加しました";
            } else {
                $pdo->rollBack();
            }
        }
    } catch (PDOException $e) {
        $error_message[] = $e->getMessage();
        $pdo->rollBack();
    }
}
//切り替え
if ($action === "toggle") {
    if (isset($_POST["product_id"])) {
        try {
            $pdo->beginTransaction();
            $message = togglePublic();
            if (empty($error_message)) {
                $pdo->commit();
            }
        } catch (Exception $e) {
            $error_message[] = 'データベースエラー：' . $e->getMessage();
            $pdo->rollBack();
        }
    }
}

//削除
if ($action === "delete") {
    if (isset($_POST["product_id"])) {
        try {
            $pdo->beginTransaction();
            $message = deleteProduct($message);
            if (isset($message) && empty($error_message)) {
                $pdo->commit();
            }
        } catch (Exception $e) {
            $error_message[] = 'データベースエラー：' . $e->getMessage();
            $pdo->rollBack();
        }
    }
}

//数量変更
if ($action === "update_qty") {
    if (isset($_POST["product_id"]) && isset($_POST["stock_qty"]) && $_POST["stock_qty"] >= 0) {
        try {
            $pdo->beginTransaction();
            $error_message = updateQty($error_message);
            if (empty($error_message)) {
                $pdo->commit();
                $message[] = "在庫数を変更しました";
            }
        } catch (Exception $e) {
            $error_message[] = 'データベースエラー：' . $e->getMessage();
            $pdo->rollBack();
        }
    } else {
        $error_message[] = "数量を0以上の整数で指定してください";
    }
}

$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$product_data = getProducts() ?? [];
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