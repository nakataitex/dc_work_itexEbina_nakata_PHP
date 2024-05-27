<table>
    <tr>
        <caption>商品一覧</caption>
        <th>商品名</th>
        <th>価格</th>
        <th>画像</th>
        <th>個数指定して追加してください</th>
    </tr>
    <?php
    foreach ($product_view_data as $value) { ?>
        <tr class="shopping">
            <td><?php print $value["product_name"]; ?></td>
            <td><?php print $value["price"]; ?>円</td>
            <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
            </td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                    <?php
                    if (isset($value["stock_qty"]) && (int)$value["stock_qty"] === 0): ?>
                        <p>売り切れ</p>
                    <?php else: ?>
                        個数：<input type="number" name="add_cart_qty" value="1" step="1" min="1" required><br>
                        <input type="submit" name="add_cart" value="カートに入れる">
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>