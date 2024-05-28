<?php
//constファイル読み込み
require_once "../../include/config/const.php";
//modelファイル読み込み
require_once "../../include/model/CommonModel.php";
require_once "../../include/model/UserModel.php";

session_start();
loginCheck();

$error_message = [];
$message = [];
$user = $_POST["user_name"] ?? "";
$password = $_POST["password"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($user_name === "" || $password === "") {
        $error_message[] = "ユーザーとパスワードを入力してください";
    } else {
        $result = authenticateUser();
        if (is_array($result)) { // ユーザー情報が配列で返ってきた場合
            session_regenerate_id(true);
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $result["user_id"];
            $_SESSION["user_name"] = $result["user_name"];
            if ($_SESSION["login"] && isset($_SESSION["user_name"]) && $_SESSION["user_name"] === "ec_admin") {
                header("Location: ./Manage.php");
                exit();
            } else {
                header("Location: ./Catalog.php");
                exit();
            }
        } else {
            $error_message[] = $result; // エラーメッセージを追加
        }
    }
}

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//CSSファイルの選択
$stylesheet = "./assets/Style.css";
//ページタイトル
$page_title = "ログイン画面";
//ページリンク
$menus = [
    "./Register.php" => "会員登録"
];

//viewファイル読み込み
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/LoginView.php";
include_once "../../include/view/FooterView.php";