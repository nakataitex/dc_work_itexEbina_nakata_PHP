<?php
//Model(model.php)を読み込む
require_once 'work39_model.php';

$image_data = [];//画像データ
$pdo = get_connection();//接続
$image_data = get_image_list($pdo);
$image_data = h_array($image_data);


//view(view.php)読み込み
include_once 'work39_view.php';
//インクルードワンスはファイルがない場合、エラーが出るが処理は続行される