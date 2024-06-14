<div class="form_container">
    <form method="post" enctype="multipart/form-data">
        商品名：<input type="text" name="product_name" required><br>
        価格：<input type="number" name="price" step="1" min="0" max="999999999" required><br>
        在庫数：<input type="number" name="stock_qty" step="1" min="0" max="999999999" required><br>
        画像を選択：<input type="file" name="image" required><br>
        公開<input type="radio" name="public_flg" value="public">
        非公開<input type="radio" name="public_flg" value="private" checked><br>
        <input type="hidden" name="action" value="add">
        <input type="submit" value="登録">
    </form>
</div>
<?php if (isset($product_data) && !empty($product_data)): ?>
    <table>
        <caption>商品一覧</caption>
        <tr>
            <th>商品名</th>
            <th>画像</th>
            <th>在庫数</th>
            <th>単価</th>
            <th>ステータス</th>
        </tr>
        <?php
        foreach ($product_view_data as $value) { ?>
            <div class="<?php print ($value["public_flg"] === "1") ? "public" : "private"; ?>">
                <tr>
                    <td><?php print $value["product_name"]; ?><br>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="submit" value="削除する">
                        </form>
                    </td>
                    <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                    </td>
                    <td><?php print $value["stock_qty"]; ?>個<br>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                            <input type="hidden" name="action" value="update_qty">
                            <input type="number" name="stock_qty" min="0" required>
                            <input type="submit" value="在庫数変更">
                        </form>
                    </td>
                    <td><?php print $value["price"]; ?>円</td>
                    <td><?php print ($value["public_flg"] === "1") ? "公開中" : "非公開"; ?>
                        <br>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                            <input type="hidden" name="action" value="toggle">
                            <input type="submit" value="<?php print ($value["public_flg"] === "1") ? "非公開にする" : "公開する";
                            ; ?>">
                        </form>
                        <br>
                    </td>
                </tr>
            </div>
        <?php } ?>
    </table>
<?php endif; ?>