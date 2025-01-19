<?php
//定数を読み込む
require_once '../../include/test/config/const.php';
//Modelを読み込む
require_once '../../include/test/model/common_model.php';
require_once '../../include/test/model/cart_model.php';

session_start();
commonUserCheck();

$user_name = helloUser(getUserName());

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();
//カート内のデータを取得
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    try {
        $cart_data = getCart() ?? "";
    } catch (Exception $e) {
        $error_message[] = $e->getMessage();
    }

    //注文
    if ($action === "buy") {
        try {
            $order_id = order($cart_data, $pdo);
            if ($order_id) {
                $_SESSION["order_id"] = $order_id;
                header("Location: ./purchase.php");
                exit();
            }
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }

    //削除
    if ($action === "delete") {
        try {
            $message = deleteFromCart($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }

    //数量変更
    if ($action === "update_qty") {
        try {
            $message = updateQtyFromCart($pdo);
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
}

//viewで表示するデータ
$display_error_message = convertToArray($error_message) ?? [];
$display_message = convertToArray($message) ?? [];

//最新のカート内のデータを取得
try {
    $cart_data = getCart() ?? "";
} catch (Exception $e) {
    $error_message[] = $e->getMessage();
}
if (isset($cart_data)) {
    $total_amount = getTotalAmount($cart_data);
    $array_cart_data = convertToArray($cart_data) ?? [];
    $cart_view_data = hArray($array_cart_data) ?? [];
}

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "カート";
//ページリンク
$menus = [
    "catalog.php" => "商品一覧",
    "#1" => "注文履歴(準備中)",
    "#2" => "アカウント(準備中)",
    "./logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/test/view/header_view.php";
include_once "../../include/test/view/cart_view.php";
include_once "../../include/test/view/footer_view.php";
