<h1>カート</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="buy">
    <input type="submit" value="商品を購入する">
</form>


<table>
    <tr>
        <th>商品名</th>
        <th>画像</th>
        <th>価格</th>
        <th>状態</th>
        <th>削除</th>
    </tr>
    <?php
    foreach ($cart_view_data as $value) { ?>
        <div class="product_group">
            <tr>
                <td><?php print $value["product_name"]; ?><br>
                </td>
                <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                </td>
                <td><?php /* print $value["price"];  */ ?>円</td>
                <td><?php print ($value["product_qty"]) . '個'; ?>
                    <br>
                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                        <input type="number" name="<?php $value["product_qty"] ?>" value="<?php $value["product_qty"]; ?>"
                            min="1" required>
                        <input type="hidden" name="action" value="update_qty">
                        <input type="submit" value="変更する">
                    </form>
                    <br>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>"><?php echo $value["product_id"]; ?>
                        <input type="hidden" name="action" value="delete">
                        <input type="submit" value="カートから削除する">
                    </form>
                </td>
            </tr>
        </div>
    <?php } ?>
</table>