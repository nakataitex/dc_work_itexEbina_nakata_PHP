<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work34</title>
</head>

<body>
    <?php
    $dsn = "mysql:host=localhost;dbname=xb513874_u338x";
    $login_user = "xb513874_fpu2g";
    $password = "mj3mt8vtwv";



    try {
        //データベースに接続
        $db = new PDO($dsn, $login_user, $password);
        //エラー起きたら
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //トランザクション開始
        $db->beginTransaction();

        //クエリ文
        $sql = "SELECT product_name,price,product_id FROM product WHERE price > ?";

        $stmt = $db->prepare($sql);


        $stmt->bindValue(1, 100);

        $stmt->execute();
        $row = $stmt->rowCount();
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ):
            echo 'これは'.$row["product_name"].'です。価格は'.$row["price"].'円です。<br>';
        endwhile;

    } catch (PDOException $e) {

        echo $e->getMessage();
    }
    ?>
</body>

</html>