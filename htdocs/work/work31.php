<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work31</title>
</head>

<body>
    <?php
    $dsn = "mysql:host=localhost;dbname=xb513874_u338x";
    $login_user = "xb513874_fpu2g";
    $password = "mj3mt8vtwv";

    //接続
    try {
        $pdo = new PDO($dsn, $login_user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    //SELECT
    $sql = "SELECT 
    product.product_name,
    product.product_id,
    category.category_id,
    category.category_name,
    product.price
     FROM
         product
         LEFT JOIN category
         ON product.product_id = category.category_id
     WHERE category.category_id = 1;";

/* テキストから抜粋
    $sql3 =  "SELECT
    product.product_name
    , category.category_name
    , product.price
FROM
    product
    LEFT JOIN category
    ON product.category_id = category.category_id
WHERE
    product.price <= 100;"; */


    $sql2 = "SELECT product_name,price FROM product WHERE price > 100;";



    if ($result = $pdo->query($sql)):
//        $id1 = $result->fetch();
/*         echo '名前' . $id1['product_name'] . ' 、カテゴリ名' . $id1['category_name']; */
        while($row = $result->fetch()):
            echo $row["category_name"].'の'.$row["product_name"].'は'.$row["price"].'円です。<br>';
        endwhile; 
endif;


    ?>

</body>

</html>