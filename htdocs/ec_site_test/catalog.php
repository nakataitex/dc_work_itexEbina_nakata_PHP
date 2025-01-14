<?php
//定数(const.php)を読み込む
require_once '../../include/test/config/const.php';
//Model(ec_model.php)を読み込む
require_once '../../include/test/model/common_model.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/test/model/catalog_model.php';

session_start();
commonUserCheck();

$product_data = [];//商品データ
$message = [];
$error_message = [];
$pdo = getConnection();

//カートに追加
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";
    if ($action === "add") {
        try {
            $message[] = addCart();
        } catch (Exception $e) {
            $error_message[] = $e->getMessage();
        }
    }
}

$product_public_flg = 1;
$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";
$catalog_num = getProductCount(PUBLIC_FLG_PUBLIC);
$pagination_limit = getViewLimit();
$catalog_data = getCatalogVariable($pdo, $product_public_flg) ?? "";
$array_catalog_data = convertToArray($catalog_data) ?? "";
$catalog_view_data = hArray($array_catalog_data) ?? "";
$current_display_count = count($catalog_data);
$max_page_num = get_max_page_num($pagination_limit, $catalog_num);


//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "商品一覧";
//ページリンク
$menus = [
    "./cart.php" => "カート",
    "./logout.php" => "ログアウト"
];

//Viewファイルを読み込む
include_once "../../include/test/view/header_view.php";
include_once "../../include/test/view/catalog_view.php";
include_once "../../include/test/view/footer_view.php";
