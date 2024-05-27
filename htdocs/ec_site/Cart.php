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

/* //注文
 if ($action === "buy") {
    try {
        $pdo->beginTransaction();
        $error_message = validationAddProduct($pdo, $error_message);
        if (empty($error_message)) {
            $error_message = addProduct($pdo, $error_message);
            if (empty($error_message)) {
                $pdo->commit();
                $message[] = "商品を購入しました";
            } else {
                $pdo->rollBack();
            }
        }
    } catch (PDOException $e) {
        $error_message[] = $e->getMessage();
        $pdo->rollBack();
    }
} */

//削除
if ($action === "delete") {
    if (isset($_POST["product_id"])) {
        try {
            $pdo->beginTransaction();
            $message = deleteFromCart($message);
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
    if (isset($_POST["product_id"]) && isset($_POST["product_qty"]) && $_POST["product_qty"] >= 0) {
        try {
            $pdo->beginTransaction();
            $error_message = updateCartQty($error_message);
            if (empty($error_message)) {
                $pdo->commit();
                $message[] = "個数を変更しました";
            }
        } catch (Exception $e) {
            $error_message[] = 'データベースエラー：' . $e->getMessage();
            $pdo->rollBack();
        }
    } else {
        $error_message[] = "数量は1以上の整数を指定してください";
    }
} 

$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];
$cart_data = getCart() ?? [];
$array_cart_data = convertToArray($cart_data) ?? [];
$cart_view_data = h_array($array_cart_data) ?? [];


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
echo $cart_view_data[1]["product_name"];