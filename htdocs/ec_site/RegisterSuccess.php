<?php
//modelファイル読み込み
require_once "../../include/model/CommonModel.php";
session_start();
loginCheck();

$error_message =[];
$message = [];
if($_SESSION["success"]){
    unset($_SESSION);
    $message[] = "登録完了しました";
}else{

}



//CSSファイルの選択
$stylesheet = "./assets/style.css";
//ページタイトル
$page_title = "登録完了";
//CSSファイルの選択
$menus = [
    "./Login.php" => "ログイン"
];

$display_error_message = convertToArray($error_message) ?? "";
$display_message = convertToArray($message) ?? "";

//viewファイル読み込み
include_once "../../include/view/HeaderView.php";
include_once "../../include/view/RegisterSuccessView.php";
include_once "../../include/view/FooterView.php";