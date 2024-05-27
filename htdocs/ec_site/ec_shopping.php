<?php
session_start();
//Model(ec_model.php)を読み込む
require_once '../../include/model/ec_model.php';
login_check();

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
 //Model(ec_product_model.php)を読み込む
require_once '../../include/model/ec_shopping_model.php';

$product_data = [];//商品データ
$pdo = get_connection();//接続
$user_id = $_SESSION["user_id"];
$user = $_SESSION["user_name"];
$message = [];

//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") { //ポストがあった時に動作
    //商品をカートに入れる
    if (isset($_POST["add_cart"])) {
        if (validation_int($_POST["add_cart_qty"])) {
            $product_id = $_POST["product_id"];//商品ID
            $add_cart_qty = $_POST["add_cart_qty"];//カートに入れようとした数
            $date = current_date();
            
            $add_cart_param = [
                ":user_id" => $user_id,
                ":product_id" => $product_id,
            ];
            //カートに入れようとした商品がカート内にあるか確認
            $check_cart = check_cart($add_cart_param);
            if (isset($check_cart["product_qty"])) {
                $cart_qty = $check_cart["product_qty"];//カート内の商品数
                var_dump($check_cart["product_qty"]);
            } else {
                $cart_qty = 0;//なければ変数を初期化
                
            }
            //在庫の確認
            $add_cart_qty = (int)$_POST["add_cart_qty"];//カートに入れようとした数
            var_dump($add_cart_qty);
            $product_qty = $cart_qty + $add_cart_qty;//カートに入れようとした数とカート内の数の合計
            $stock_qty_check = stock_qty_check($product_id);
            $stock_qty = $stock_qty_check["stock_qty"];//在庫数
            //在庫数よりカートに入れる数が少なければ続行
            if ($product_qty < $stock_qty_check["stock_qty"] && empty($message["error"])) {
                $add_cart_param[":product_qty"] = $product_qty;
                $add_cart = add_cart($product_qty,$add_cart_param);
                if ($add_cart) {
                    $message["normal"]["shopping"][] = "add_cart";
                } else {
                    $message["error"]["db"][] = "db_error";
                }
            } else {
                $message["error"]["shopping"][] = "stock_qty";
            }
        } else {
            $message["error"]["shopping"][] = "qty_param";
        }
    }
}
//通知メッセージ
//リンク：カート、ログアウト

//商品リストを読み込む
$product_data = get_product_list($pdo);
$convert_data = array_convert_product_data($product_data);
$product_view_data = h_array($convert_data);
//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "商品一覧";
//ページリンク
$menus = [
    "./ec_cart.php" => "カート",
    "./ec_logout.php" => "ログアウト"
];

//ログイン画面のヘッダーまでを読み込む
include_once ("../../include/view/ec_header_view.php");
//view(ec_product_manage_view.php)読み込み
include_once '../../include/view/ec_shopping_view.php';
//ログイン画面のフッターを読み込む
include_once ('../../include/view/ec_footer_view.php');