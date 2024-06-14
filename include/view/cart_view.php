<?php if (isset($cart_data) && !empty($cart_data)):
    ?>
    <table>
        <tr>
            <th>商品名</th>
            <th>画像</th>
            <th>単価</th>
            <th>個数</th>
            <th>カートから削除</th>
        </tr>
        <?php
        foreach ($cart_view_data as $value) { ?>
            <tr>
                <td><?php print $value["product_name"]; ?></td>
                <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                </td>
                <td><?php print $value["price"]; ?>円</td>
                <td><?php print ($value["stock_qty"] === "0") ? "在庫：売り切れ" : "販売中"; ?>
                    <br>
                    <?php if ($value["stock_qty"] < 20 && $value["stock_qty"] > 0): ?>
                        <p class="low-stock">残り少なくなっています<br>
                            在庫<?php print ($value['stock_qty']); ?>個</p>
                    <?php endif; ?>
                    カート：<?php print ($value["product_qty"]) . '個'; ?>
                    <br>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php print $value["product_id"]; ?>">
                        <input type="number" name="product_qty" value="<?php print $value["product_qty"]; ?>" min="1" required>
                        <input type="hidden" name="action" value="update_qty">
                        <input type="submit" value="数量変更">
                    </form>
                    <br>
                </td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php print $value["product_id"]; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="submit" value="削除する">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <h3>小計：<?php print $total_amount; ?>円</h3>
    <form method="post"><?php ; ?>
        <input type="hidden" name="action" value="buy">
        <input type="submit" value="商品を購入する">
    </form>
<?php endif; ?>