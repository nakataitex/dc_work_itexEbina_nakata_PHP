<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$db = new mysqli($host, $login_user, $password, $database);
$error_msg = [];
date_default_timezone_set('Asia/Tokyo');
$date = date("Y-m-d");



if ($db->connect_error):
    echo "DB接続エラー$db->connect_error<br>";
    exit();
else:
    $db->set_charset("utf8");
    echo "DB接続完了<br>";
endif;

$image_name = "test";

//SQL
$db->begin_transaction();//トランザクション開始
$insert = "INSERT INTO image_sharing(
        image_name,
        public_flg,
        create_date
        )
    
    VALUES(
        '$image_name',
        'private',
        '$date'
    )";


if ($result = $db->query($insert)):
    $row = $db->affected_rows;
    echo "if(result)成功";
else:
    $error_msg[] = "INSERT実行エラー[実行SQL]" . $insert;
endif;

if (count($error_msg) > 0)://エラーメッセージがあるなら
    echo "挿入失敗<br>";//ログ
    $db->rollback();//ロールバック。全取り消し
else:
    echo "$row の挿入に成功しました。<br>";
    $db->commit();//コミット。反映させる
endif;
