<?php
session_start();
if (isset($_SESSION["login"]) && isset($_SESSION["user_name"])) {
    $user_id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
} else {
    header("Location: ./ec_login.php");//管理者以外はログインページへ移動、ログインしてる場合はその後index.phpに移動
    exit();
}

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//Model(ec_model.php)を読み込む
require_once '../../include/model/ec_model.php';
//Model(ec_product_model.php)を読み込む
require_once '../../include/model/ec_shopping_model.php';

$product_data = [];//商品データ
$pdo = get_connection();//接続

$message = [];

if (isset($_POST['form'])) {
    $form = $_POST['form'];
} else {
    //フォーム情報の初期化
/*     $form = [
        "product_name" => "",
        "price" => "",
        "stock_qty" => "",
        "image_name" => "",
        "create_date" => "",
        "product_id" => "",
    ]; */
}
//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") { //ポストがあった時に動作
    //商品をカートに入れる
    if (isset($_POST["add_cart"])) {
        try {
            //既にカートにないか確認
            $check_cart_sql = 'SELECT product_qty, product_id, user_id FROM ec_cart_table WHERE user_id = :user_id AND product_id = :product_id';
            $product_id = $_POST["product_id"];
            $check_cart_param = [
                ":user_id" => $user_id,
                ":product_id" => $product_id
            ];

            $check_cart = sql_fetch_data($check_cart_sql, $check_cart_param);
            $cart_qty = intval($check_cart["product_qty"]);//カート内の商品数
            echo ' カート内の数は ' . $check_cart["product_qty"];
            var_dump($cart_qty);
            //在庫の確認
            $add_cart_qty = intval($_POST["add_cart_qty"]);//カートに入れようとした数
            $stock_qty_sql = 'SELECT stock_qty FROM ec_stock_table WHERE product_id = :product_id';
            $stock_qty_param = [
                ":product_id" => $product_id
            ];
            $product_qty = $cart_qty + $add_cart_qty;
            $stock_qty = sql_fetch_data($stock_qty_sql, $stock_qty_param);
            echo '在庫数'.$stock_qty["stock_qty"];
            var_dump($stock_qty);
            //在庫数よりカートに入れる数が少なければ続行
            if ($add_cart_qty < $stock_qty) {
                $date = current_date();
                if ($cart_qty === 0) {
                    $add_cart_sql =
                        'INSERT INTO  
                        ec_cart_table (user_id,product_id,product_qty,create_date)VALUES(:user_id,:product_id,:product_qty,:create_date)';

                    $add_cart_param = [
                        ":user_id" => $user_id,
                        ":product_id" => $product_id,
                        ":product_qty" => $product_qty,
                        ":create_date" => $date
                    ];
                } else {
                    $add_cart_sql =
                        'UPDATE ec_cart_table SET product_qty = :product_qty, update_date = :update_date WHERE user_id = :user_id AND product_id = :product_id';

                    $add_cart_param = [
                        ":product_qty" => $product_qty,
                        ":update_date" => $date,
                        ":user_id" => $user_id,
                        "product_id" => $product_id
                    ];
                }
                $add_cart = sql_fetch_data($add_cart_sql, $add_cart_param);
                if ($add_cart) {
                    $message["normal"]["shopping"] = "add_cart";
                    echo "カート追加のテストメッセージ";
                } else {
                    $message["error"]["db"][] = "db_error";
                }
            } else {
                $message["error"]["shopping"][] = "stock_qty";
            }

        } catch (Exception $e) {
            $message["error"]["db"][] = $e->getMessage();
        }
    }
}
echo "ユーザーid$user_id";

var_dump($message);

//商品リストを読み込む(現在管理用)
$product_data = get_product_list($pdo);
$product_view_data = h_array($product_data);

//view(ec_product_manage_view.php)読み込み
include_once '../../include/view/ec_shopping_view.php';