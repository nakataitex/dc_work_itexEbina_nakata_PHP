<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
$product_name;
$price;
$price_val;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try40</title>
</head>

<body>
    <?php
    //データベースへ接続
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_error):
        echo $db->connect_error;
        exit();
    else:
        $db->set_charset("utf8");
    endif;

    if ($_SERVER["REQUEST_METHOD"] == "POST"):
        if (isset($_POST["price"])):
            $price = $_POST["price"];
        endif;
        $db->begin_transaction();//トランザクション開始
    
        //UPDATE開始
        $update = "UPDATE product SET price =" . $price . " WHERE product_id = 1;";//WHEREの前にスペースを入れないとエラーが出る
        if ($result = $db->query($update)):
            $row = $db->affected_rows;
        else:
            $error_msg[] = 'UPDATE実行エラー[実行SQL]' . $update;//エラーメッセージ挿入
        endif;


        //$error_msg[]= "強制的にエラーメッセージを挿入";
    
        //エラーメッセージ格納の有無によりトランザクションの成否を判定
    
        if (count($error_msg) == 0)://エラーメッセージがないなら
            echo $row . '件更新しました。';//更新ログ
            $db->commit();//コミット
        else://更新失敗したら
            echo "更新失敗しました。";//ログ
            $db->rollback();//ロールバック
        endif;
        //下記はエラー確認用。エラー確認が必要な際にはコメントを外してください。
        var_dump($error_msg);
    endif;

//クエリ
    $select = "SELECT product_name, price FROM product WHERE product_id = 1 ;";
    if ($result = $db->query($select))://$dbに対して$selectを実行成功したら$resultにtrueを返す
        //連想配列を取得
        while ($row = $result->fetch_assoc())://resultの連想配列を
            $product_name = $row["product_name"];
            $price = $row["price"];
        endwhile;

        //結果セットを閉じる
        $result->close();
    endif;

    if ($price == 150):
        $price_val = 130;
    else:
        $price_val = 150;
    endif;

    $db->close(); //接続を閉じる
    
    ?>
    <form method="post">
        <p><?php echo $product_name . 'の現在の価格は' . $price . '円です</p>'; ?>
            <input type="radio" name="price" value="<?php echo $price_val ?>" checked><?php echo $price_val ?>円に変更する
            <input type="submit" value="送信">
    </form>
</body>

</html>