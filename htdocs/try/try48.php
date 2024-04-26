<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try48</title>
</head>
<body>
    <?php
        //DB接続情報
$dsn = "mysql:host=localhost;dbname=xb513874_u338x";
$login_user = "xb513874_fpu2g";
$password = "mj3mt8vtwv";

try{
    //データベースへ接続
    $db = new PDO($dsn, $login_user,$password);
    //PDOエラー時にPDOExceptionが発生する様に設定
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->beginTransaction();//トランザクション開始
    //クエリ作成
    $sql = 'UPDATE product SET price = ? WHERE product_id = ?';
    
    //prepareメソッドによるクエリ実行準備
    $stmt = $db ->prepare($sql);
    //値をバインド
    $stmt->bindValue(1,170);
    $stmt->bindValue(2,'1');

    //クエリの実行
    $stmt->execute();
    $row= $stmt->rowCount();
    echo "$row 件更新";
    $db->commit();//正常に完了したらコミット 

}catch(PDOException $e){
    echo $e->getMessage();
    $db->rollBack();//エラー出たらロールバック
}
    ?>
</body>
</html>