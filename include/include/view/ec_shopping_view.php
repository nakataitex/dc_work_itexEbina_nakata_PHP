<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ECサイト]ショッピングページ</title>
    <link rel="stylesheet" href="./assets/ec_product_style.css">
</head>

<body>
    <h1>ショッピングページ</h1>
    <div class="menu">
        <a href="./ec_logout.php">ログアウト</a>
    </div>
    <?php
    //通知の表示
    echo display_message($message, $message_list);
    ?>
    <table>
        <tr>
            <caption>商品一覧</caption>
            <th>商品名</th>
            <th>作成日</th>
            <th>画像</th>
            <th>在庫数</th>
            <th>価格</th>
            <th>状態</th>
        </tr>
        <?php
        foreach ($product_view_data as $value) { ?>
            <tr class="shopping">
                <td><?php print $value["product_name"]; ?></td>
                <td><?php print $value["create_date"]; ?></td>
                <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                </td>
                <td><?php print $value["stock_qty"]; ?>個</td>
                <td><?php print $value["price"]; ?>円</td>
                    <br>
                    <form action="" method="POST">
                        個数：<input type="number" name="add_cart_qty" step="1" min="1" required><br>
                        <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                        <input type="submit" name="add_cart" value="カートに入れる">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>