<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try45</title>
</head>
<body>
    <?php
    $dsn ="mysql:host=localhost;dbname=xb513874_u338x";
    $login_user = "xb513874_fpu2g";
    $password = "mj3mt8vtwv";

    //接続
    try{
        $db = new PDO($dsn, $login_user, $password);
    }
    catch(PDOException $e){
        echo $e->getMessage();
        exit();
    }

    //SELECT文の実行
    $sql = "SELECT product_name, price FROM product WHERE price <= 100";
    if($result = $db ->query($sql)){
        //連想配列を取得
        while ($row = $result->fetch()):
            echo $row["product_name"]. $row["price"]."<br>";
        endwhile;
        
        }
    ?>
</body>
</html>