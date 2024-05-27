    <h1>商品管理ページ</h1>
    <div class="form_container">
        <form method="post" enctype="multipart/form-data">
            商品名：<input type="text" name="product_name" required><br>
            価格：<input type="number" name="price" step="1" min="0" max="99999999" required><br>
            在庫数：<input type="number" name="stock_qty" step="1" min="0" max="99999999" required><br>
            画像を選択：<input type="file" name="image" required><br>
            公開<input type="radio" name="public_flg" value="public">
            非公開<input type="radio" name="public_flg" value="private" checked><br>
            <input type="submit" value="登録" name="add_product">
        </form>
    </div>
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
            <?php $public = get_public_button_and_class($value) ?>
            <tr class="<?php print $public['public_class']; ?>">
                <td><?php print $value["product_name"]; ?></td>
                <td><?php print $value["create_date"]; ?></td>
                <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                </td>
                <td><?php print $value["stock_qty"]; ?>個</td>
                <td><?php print $value["price"]; ?>円</td>
                <td><?php print $public["public_status"]; ?>
                    <br>
                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $value["product_id"];?>">
                        <input type="submit" name="toggle_public" value="<?php print $public['public_button'] ?>">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>