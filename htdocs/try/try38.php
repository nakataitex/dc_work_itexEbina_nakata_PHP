<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $db = new mysqli('localhost', 'xb513874_fpu2g', "mj3mt8vtwv", "xb513874_u338x");
    if($db->connect_error)://接続失敗かどうか
        echo $db->connect_error;
        exit();
    else://接続成功
        $db->set_charset("utf-8");//文字コード指定
        echo "接続成功！<br>";
    endif;

    //select実行
    $sql = "SELECT product_name, price FROM product WHERE price <= 100";//SQLで実行したい事
    if($result = $db->query($sql))://$dbに対してクエリ実行、結果がtrueなら以下を実行
        echo "クエリの実行が出来た。以下whileループ処理を行う。<br>";
        //連想配列を取得
        while($row = $result ->fetch_assoc())://resultオブジェクトのデータ・キーを連想配列に変換、その後配列を$rowに代入
            echo $row["product_name"]."：". $row["price"]."円<br>";//各行の商品名と価格を表示
            //結果セットを閉じる
        endwhile;
            $result->close();
    endif;
    $db->close();//接続終了            
?>
</body>
</html>