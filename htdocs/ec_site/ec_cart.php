<?php
/* 
カートの中身一覧を表示
金額の小計表示
カートから削除
商品の数量変更(+のみ)
購入するボタン→購入完了ページへ
カート内の商品が購入までに在庫がなくなった場合エラーを表示
リンク：商品一覧、ログアウト
*/
session_start();
if (isset($_SESSION["login"]) && isset($_SESSION["user_name"])) {
    $user_id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
} else {
    header("Location: ./ec_login.php");//管理者以外はログインページへ移動、ログインしてる場合はその後index.phpに移動
    exit();
}
$message = [];

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';
//モデル追加
require_once "../../include/model/ec_cart_model.php";


//フォーム情報の初期化
/* if (isset($_SESSION['cart']) && $_SESSION["cart"] !== "") {
    $cart = $_SESSION['cart'];
} else {
    $product = [
        "product_name" => "",
        "price" => "",
        "image_name" => "",
        "create_date" => "",
        "product_id" => "",
    ];
}
 */
 if ($_SERVER['REQUEST_METHOD'] === "POST") {
    //購入ボタンを押した時(未実装)
    if (isset($_POST["buy"]))
        try {
            if ($products) {
                //注文に必要な情報
                $user_id;//id
                $date = current_date();//order_date
                foreach($products as $product){
                    $total_amount +=$product["price"] * $product["product_qty"];
                }
                var_dump($total_amount);

                $pdo->beginTransaction();
                foreach($products as $product => $value)
                $product["product_id"] = $pdo->lastInsertId();
                insert_image($pdo, $product);
                insert_stock($pdo, $product);
                $message["normal"]["product_manage"][] = "add_product";
                $pdo->commit();
                $session["form"] = $form;
                header("Location: ./ec_product_manage.php");
            }
        } catch (PDOException $e) {
            $message["error"]["db"][] = "db_error";
            $pdo->rollBack();
        }
} 

foreach($products as $product){
    $total_amount +=$product["price"] * $product["product_qty"];
}
var_dump($total_amount);
//削除ボタンを押した時
if (isset($_POST["remove_from_cart"])) {
    try {
        $pdo->beginTransaction();
        $date = current_date();
        $remove_product_id = $_POSt["product_id"];
        $row = delete_from_cart($product_id, $user_id);
        if (!$row) {
            $message["error"]["db"][] = "db_error";
        }else{
            $message["normal"]["cart"][] = "delete_from_cart";
            $pdo->commit();
        }
        header("Location: ec_product_manage.php");//ブラウザ画面更新時にフォームの再送信の通知を止める為
        exit();
    } catch (Exception $e) {
        $message["error"]["db"][] = $e->getMessage();
        $pdo->rollBack();
        exit();
    }
}




//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "カート";
//リンク
$menus = [
    "./ec_shopping.php" => "商品一覧",
    "./ec_logout.php" => "ログアウト"
];


$cart_data = get_cart_list($user_id);
$cart_view_data = h_array($cart_data);

/* var_dump($cart_data); */
/* $cart_view_data = h_array($cart_data); */

//ログイン画面のヘッダーを読み込む
include_once ("../../include/view/ec_header_view.php");
//ログインのView(ec_login_view.php)を読み込む
include_once "../../include/view/ec_cart_view.php";
//ログイン画面のフッターを読み込む
include_once ('../../include/view/ec_footer_view.php');