<?php
//modelファイル読み込み
require_once "../../include/model/common_model.php";
session_start();
loginCheck();

$message = [];
$error_message =[];

if($_SESSION["success"]){
    unset($_SESSION);
    $message[] = "登録完了しました";
}else{
    $error_message = "登録に失敗しました。管理者に連絡してください";
}



//CSSファイルの選択
$stylesheet = CSS_DIR;
//ページタイトル
$page_title = "登録完了";
//CSSファイルの選択
$menus = [
    "./login.php" => "ログイン"
];

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//viewファイル読み込み
include_once "../../include/view/header_view.php";
include_once "../../include/view/register_success_view.php";
include_once "../../include/view/footer_view.php";