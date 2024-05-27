<?php
/* 
今回！購入した商品の一覧
小計
購入に成功時、在庫数を減らす
カート内削除
リンク：商品一覧、ログアウト
*/

//CSSファイルの選択
$stylesheet = "./assets/ec_style.css";
//ページタイトル
$page_title = "購入完了";
//CSS
$menus = [
    "./ec_shopping.php" => "商品一覧",
    "./ec_logout.php" => "ログアウト"
];

//ログイン画面のヘッダーまでを読み込む
include_once("../../include/view/ec_header_view.php");

include_once("../../include/view/ec_purchase_view.php");