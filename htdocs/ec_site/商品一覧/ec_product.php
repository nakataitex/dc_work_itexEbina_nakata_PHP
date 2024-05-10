<?php
//定数(const.php)を読み込む
require_once 'const.php';

//Model(model.php)を読み込む
require_once 'ec_product_model.php';

$product_data = [];//商品データ
$pdo = get_connection();//接続
$product_data = get_product_list($pdo);
$product_view_data = h_array($product_data);


//view(view.php)読み込み これはテスト表示用。
include_once 'ec_product_list_view.php';