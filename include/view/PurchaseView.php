<h1>購入が完了しました</h1>
<table>
    <tr>
        <th>商品名</th>
        <th>数量</th>
        <th>価格</th>
        <th>小計</th>
    </tr>
    <?php foreach ($order_view_data as $item): ?>
        <tr>
            <td><?php $item['product_name'] ?></td>
            <td><?php $item['product_qty'] ?></td>
            <td><?php $item['price'] ?></td>
            <td><?php $item['total'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="Catalog.php">商品一覧に戻る</a></p>