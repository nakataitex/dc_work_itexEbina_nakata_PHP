<?php
//定数ファイル読み込み
require_once "../../include/test/config/const.php";
//modelファイル読み込み
require_once "../../include/test/model/common_model.php";
require_once "../../include/test/model/user_model.php";
session_start();
loginCheck();

$message = [];
$error_message = [];

if (isset($_SESSION["success"])) {
    try {
        $message = registerSuccess();
    } catch (Exception $e) {
        $error_message[] = $e->getMessage();
    }
}

//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "ユーザー登録完了";
//CSSファイルの選択
$menus = [
    "./login.php" => "ログイン"
];

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//viewファイル読み込み
include_once "../../include/test/view/header_view.php";
include_once "../../include/test/view/register_success_view.php";
include_once "../../include/test/view/footer_view.php";