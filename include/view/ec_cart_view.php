<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <tr>
        <caption>カート内の商品</caption>
        <th>画像</th>
        <th>商品名</th>
        <th>注文数</th>
        <th>価格</th>
    </tr>
    <form action="" method="POST">
        <!-- カート内のものに変更が必要 -->
        <?php foreach ($cart_view_data as $value) { ?>
            <tr class="product_group"><!-- 仮のクラス名 -->
                <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                </td>
                <td><?php print $value["product_name"]; ?></td>
                <td><?php print $value["product_qty"]; ?>個</td>
                <td><?php print $value["price"]; ?>円</td>
                <br>
                <form action="" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                    <input type="submit" name="remove_from_cart" value="カートから削除">
                </form>
                </td>
            </tr>
            <?php $value["price"] += ($value["price"] * $value["cart_qty"]);
        } ?>
        <input type="submit" name="buy" value="購入する">
    </form>
</body>

</html>