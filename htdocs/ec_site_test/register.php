<?php
//定数読み込み
require_once '../../include/test/config/const.php';
//modelファイル読み込み
require_once "../../include/test/model/common_model.php";
require_once "../../include/test/model/user_model.php";

session_start();
loginCheck();
$error_message = [];
$message = [];

//フォームをチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
            $user_name = $_POST["user_name"];
            $password = $_POST["password"];
            validationUserForm();
            $result = register($password);
            if ($result === true) {
                $_SESSION["success"] = true;
                header("Location: ./register_success.php");
                exit();
            }
    } catch (Exception $e) {
        $error_message[] = $e->getMessage();
    }
}

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "ユーザー登録";
//CSSファイルの選択
$menus = [
    "./login.php" => "ログイン"
];

//Viewファイルを読み込む
include_once ("../../include/test/view/header_view.php");
include_once "../../include/test/view/register_view.php";
include_once ('../../include/test/view/footer_view.php');
