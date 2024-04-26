<?php
//DB接続情報
$dsn = "mysql:host=localhost;dbname=xb513874_u338x";
$login_user = "xb513874_fpu2g";
$password = "mj3mt8vtwv";
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try47</title>
</head>

<body>
    <?php
    try {
    //データベースへ接続
    $db = new PDO($dsn, $login_user, $password);
    //PDOエラー時にPDOExceptionが発生するように設定
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $db->beginTransaction();//トランザクション開始

//クエリ記述
$sql= "UPDATE product SET price = :price WHERE product_id = :id";

//prepareメソッドによるクエリ実行の準備
$stmt =  $db ->prepare($sql);//sqlをプリペアに。queryの代わり？

//値を割り当て
$stmt->bindValue(':price',140);
$stmt->bindValue(':id',1);

//クエリの実行
$stmt->execute();//プリペア実行
$row = $stmt->rowCount();//stmtに対してrowCount
echo "$row 件更新しました。";//ログ
$db->commit();//正常に終了したらコミット
}
catch (PDOException $e){//エラーが起こったら
    echo $e->getMessage();//ログ
    $db->rollBack();//エラーが起きたらロールバック
}


        ?>
</body>

</html>