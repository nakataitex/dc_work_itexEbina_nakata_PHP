<?php if (isset($order_id) && !empty($order_id)): ?>
    <h2>購入が完了しました</h2>
    <h3>小計金額：<?php print $total_amount["total_amount"]; ?>円</h3>
    <table>
        <tr>
            <th>画像</th>
            <th>商品名</th>
            <th>数量</th>
            <th>価格</th>
        </tr>
        <?php foreach ($order_view_data as $product): ?>
            <tr>
                <td><img src="<?php print IMG_DIR . $product['image_name'] ?>" alt="<?php print $product['product_name'] ?>">
                </td>
                <td><?php print $product['product_name'] ?></td>
                <td><?php print $product['product_qty'] ?></td>
                <td><?php print $product['price'] ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
    <p><a href="./catalog.php">商品一覧に戻る</a></p>
<?php endif; ?>