<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try46</title>
</head>

<body>
    <?php
    //DB接続情報
    $dsn = "mysql:host=localhost;dbname=xb513874_u338x";
    $login_user = "xb513874_fpu2g";
    $password = "mj3mt8vtwv";

    try {
        //db接続
        $db = new PDO($dsn, $login_user, $password);

        //pdoエラー時にPDOエクセプションが発生する様に設定
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->beginTransaction();

        //update文
        $sql = "UPDATE product SET price = 160 WHERE product_id =1";
        $result = $db->query($sql);
        $row = $result->rowCount();
        echo $row . '件更新した';
        $db->commit();//正常に終了したらコミット
        
    } catch (PDOException $e) {
        echo $e->getMessage();
        $db->rollback();//エラー起きたらロールバック
    }
    ?>

</body>

</html>