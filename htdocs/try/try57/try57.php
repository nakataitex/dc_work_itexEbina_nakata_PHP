<?php
//Model(model.php)を読み込む
require_once '../../include/model/try57_model.php';

$product_data = [];
$pdo = get_connection();
$product_data = get_product_list($pdo);
$product_data = h_array($product_data);

//view(view.php)読み込み
include_once '../../include/view/try57_view.php';
//インクルードワンスはファイルがない場合、エラーが出るが処理は続行される