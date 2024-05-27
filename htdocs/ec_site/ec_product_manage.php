<?php
session_start();
//ここも関数化出来そう
if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
    $id = $_SESSION["user_id"];
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
require_once '../../include/model/ec_product_manage_model.php';

$product_data = [];//商品データ
$pdo = get_connection();//接続

$message = [];

if (isset($_POST['form'])) {
    $form = $_POST['form'];
} else {
    //フォーム情報の初期化
    $form = [
        "product_name" => "",
        "price" => "",
        "stock_qty" => "",
        "image_name" => "",
        "public_flg" => "",
        "create_date" => "",
        "product_id" => "",
    ];
}
//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") { //ポストがあった時に動作
    if (isset($_POST["add_product"])) {//商品追加のボタンを押した時
        //名前の重複確認
        if (isset($_POST["product_name"]) && $_POST["product_name"] !== "") {
            $form["product_name"] = $_POST["product_name"];
            $product_name_count_sql = "SELECT count(*) count from ec_product_table where product_name = :product_name";
            $product_name_param = [
                ":product_name" => $form["product_name"]
            ];
            $row = duplicate_check($product_name_count_sql, $product_name_param);
            if ($row["count"] > 0) {
                $message["error"]["product_manage"][] = "duplicate";
            }
        } else {
            $message["error"]["product_manage"][] = "name_blank";
        }
        //値段が数字か確認
        if (isset($_POST["price"]) && $_POST["price"] !== "") {
            $price = $_POST["price"];
            if (!validation_int($price) || $price < 0) {//値段が0以下で登録出来ない様にする
                $message["error"]["string"][] = "price";
            } else {
                $form["price"] = (int) $price;
            }
        } else {
            $message["error"]["product_manage"][] = "price_blank";
        }
        //在庫数が数字か確認
        if (isset($_POST["stock_qty"]) && $_POST["stock_qty"] !== "") {
            $stock_qty_check = $_POST["stock_qty"];
            if (!validation_int($stock_qty_check) || $stock_qty_check < 0) {//値段が0未満か整数でない場合登録出来ない様にする
                $message["error"]["stock_qty"][] = "int";
            } else {
                $form["stock_qty"] = (int) $stock_qty_check;
            }
        } else {
            $message["error"]["product_manage"][] = "qty_blank";
        }
        //ファイルの確認
        if (isset($_FILES["image"])) {
            $temp_file = $_FILES["image"]["tmp_name"];//一時ファイル名
            if (is_uploaded_file($temp_file)) {
                if (exif_imagetype($temp_file) === IMAGETYPE_JPEG) {
                    $form["image_name"] = uniqid() . '.jpg';
                } elseif (exif_imagetype($temp_file) === IMAGETYPE_PNG) {
                    $form["image_name"] = uniqid() . '.png';
                } else {
                    $message["error"]["product_manage"][] = "file_type";
                }
                $image_dir = "./assets/img/";
                $upload_file = $image_dir . $form["image_name"];
                if (empty($message["error"]["product_manage"]) && !move_uploaded_file($temp_file, $upload_file)) {
                    $message["error"]["product_manage"][] = "upload";
                }
            } else {
                $message["error"]["product_manage"][] = "image_blank";
            }
        }
        //公開・非公開の確認
        if (isset($_POST["public_flg"])) {
            if ($_POST["public_flg"] === "public") {
                $form["public_flg"] = 1;
            } elseif ($_POST["public_flg"] === "private") {
                $form["public_flg"] = 0;
            } else {
                $message["error"]["product_manage"][] = "public_flg";
            }
        } else {
            $message["error"]["product_manage"][] = "public_flg";
        }
        //エラーがない時
        if (empty($message)) {
            $form["create_date"] = current_date();
            $_SESSION["product"] = $form;
            header("Location: ec_add_product_check.php");
            exit();
        }
    }
    //ここから公開・非公開を切り替えるボタン
    if (isset($_POST["toggle_public"])) {
        try {
            $date = current_date();
            $get_product_id = $_POST["product_id"];
            $toggle_public_sql = 
                'UPDATE 
                    ec_product_table 
                SET 
                public_flg = 1 - public_flg ,update_date = :update_date
                WHERE 
                product_id = :product_id';
            $toggle_public_param = [
                ":update_date" => $date,
                ":product_id" => $get_product_id
            ];
            $row = sql_fetch_data($toggle_public_sql, $toggle_public_param);
            if(!$row){
                $message["error"]["db"][] = "db_error";
            }
            header("Location: ec_product_manage.php");//更新時にフォームの再送信の通知を止める
            exit();
        } catch (Exception $e) {
            $message["error"]["db"][] = $e->getMessage();
        }
    }
}
//ファイル形式が違う場合のエラー修正
//数量変更機能
//削除機能
//通知メッセージ(エラー、処理完了)
//ログアウトリンク

//商品一覧を取得
$product_data = get_product_list($pdo);
$product_view_data = h_array($product_data);

//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "商品管理ページ";
//ページリンク
$menus = [
    "./ec_logout.php" => "ログアウト"
];

//ログイン画面のヘッダーまでを読み込む
include_once("../../include/view/ec_header_view.php");

//view(view.php)読み込み これはテスト表示用
include_once '../../include/view/ec_product_manage_view.php';