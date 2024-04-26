<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work33</title>
</head>

<body>
    <?php
    //接続情報
    $dsn = "mysql:host=localhost;dbname=xb513874_u338x";
    $login_user = "xb513874_fpu2g";
    $password = "mj3mt8vtwv";

    //接続してみる
    try {
        $db = new PDO($dsn, $login_user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラー時にPDOException
        $db->beginTransaction();//トランザクション開始
    
        //クエリ
        $sql = "SELECT product_id, product_name, price FROM product WHERE price > :price";
        //prepareメソッドによるクエリ実行準備
        $stmt = $db->prepare($sql);

        //値のバインド
        $stmt->bindValue(":price", 100);

        //実行
        $stmt->execute();
        
        print_r($stmt);

        while ($row = $stmt->fetch()):
            echo '<br>'.$row["product_name"] . 'は' . $row["price"] . '円です';
        endwhile;


    } catch (PDOException $e) {
        echo $e->getMessage();
        $db->rollback();
    }



    ?>
</body>

</html>