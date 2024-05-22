<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/ec_product_style.css">
    <title>[ECサイト]商品登録完了</title>
</head>

<body>
    <form action="" method="POST">
        <table>
            <tr>
                <caption>商品一覧</caption>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>画像</th>
                <th>ステータス</th>
                <th>作成日</th>
            </tr>
            <?php $public = get_public_button_and_class($product) ?>
            <td><?php print $product["product_name"]; ?></td>
            <td><?php print $product["price"]; ?>円</td>
            <td><?php print $product["stock_qty"]; ?>個</td>
            <td><img src="<?php print IMG_DIR . $product["image_name"]; ?>" alt="<?php print $product["product_name"];
                echo $dir . $product["image_name"] ?>"></td>
            <td><?php print $public["public_status"]; ?> </td>
            <td><?php print $product["create_date"]; ?></td>
            <br>
            </tr>
            <?php
            ?>
        </table>
        <input type="submit" value="商品を登録する">
    </form>
    <a href="./ec_product_manage.php">商品管理画面へ戻る</a>
</body>

</html>