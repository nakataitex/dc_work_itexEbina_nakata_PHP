<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try39</title>
</head>
<body>
    <?php
    $db = new mysqli('localhost', 'xb513874_fpu2g', "mj3mt8vtwv", "xb513874_u338x");
    if($db->connect_error):
        echo $db->connect_error;
        exit();//エラーが出たら終了
    else:
        $db->set_charset("utf8");//エラーがなければ文字コードをUTF8に設定
    endif;
    
    //SELECT文の実行
    $sql = "SELECT product_name, price FROM product WHERE price <= 100";
    if($result = $db ->query($sql)):
        //連想配列を取得
        foreach($result as $row):
            echo $row["product_name"]. $row["price"]."<br>";
        endforeach;
        
        //結果セットを閉じる
        $result ->close();
    endif;

    $db->close();  //接続を閉じる
?>
</body>
</html>