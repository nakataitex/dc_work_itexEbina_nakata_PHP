<?php
session_start();//セッションスタート
if (isset($_SESSION["login"]) && isset($_SESSION["user_name"])) {
    $id = $_SESSION["user_id"];
    $user = $_SESSION["user_name"];
    header("Location: ./index.php");//ログインしている場合トップページへ移動
    exit();
}

//定数(const.php)を読み込む
require_once '../../include/config/const.php';
//メッセージリスト(message_list.php)を読み込む
require_once '../../include/config/message_list.php';
//共通のModel(model.php)を読み込む
require_once '../../include/model/ec_model.php';

$pdo = get_connection();//接続
$message = [];

// フォームの内容があれば復元
if (isset($_GET["action"]) && $_GET["action"] === "rewrite" && isset($_SESSION["form"])) {
    $form = $_SESSION["form"];
} else {
    //セッションの情報の初期化
    $form = [
        "name" => "",
        "password" => ""
    ];
}

//フォームの内容をチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 名前チェック
    $form["name"] = $_POST["name"];
    $message["error"]["name"] = validation_user_password($form["name"], 5);
    $name_count_sql = "SELECT count(*) count from ec_user_table where user_name = :user_name";
    $name_param = [
        ":user_name" => $form["name"]
    ];
    $name_count = duplicate_check($name_count_sql, $name_param);
    if ($name_count["count"] > 0) {
        $message["error"]["name"][] = "duplicate";
    }
    // パスワードチェック
    $form["password"] = $_POST["password"];
    $message["error"]["password"] = validation_user_password($form["password"], 8);
    // エラーがない時
    if (empty($message["error"]["name"]) && empty($message["error"]["password"])) {
        $_SESSION["form"] = $form;
        header("Location: ./ec_register_check.php");
        exit();
    }
}


//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "ユーザー登録";
//CSSファイルの選択
$menus = [
    "./ec_login.php" => "ログイン"
];

//ログイン画面のヘッダーまでを読み込む
include_once("../../include/view/ec_header_view.php");
//会員登録画面を読み込む
include_once "../../include/view/ec_register_view.php";
//ログイン画面のフッターを読み込む
include_once ('../../include/view/ec_footer_view.php');