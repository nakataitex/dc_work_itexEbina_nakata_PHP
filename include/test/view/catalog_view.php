<?php if (isset($catalog_data) && !empty($catalog_data)): ?>
    <div class="paging">
    <form method="GET" >
    <label for="paging_limit">1ページ当たりの表示数</label>
    <select name="limit" id="paging_limit">
        <option value="10">10件</option>
        <option value="20">20件</option>
        <option value="30">30件</option>
        <option value="40">40件</option>
        <option value="50">50件</option>
    </select>

    </form>
    <p><?php print $catalog_num;?> 件中 <?php  ;?> 件表示中</p>
    </div>
    <table>
        <tr>
            <th>商品名</th>
            <th>画像</th>
            <th>価格</th>
            <th>ステータス</th>
        </tr>
        <?php
        foreach ($catalog_view_data as $value) { ?>
                <tr>
                    <td><?php print $value["product_name"]; ?><br>
                    </td>
                    <td><img src="<?php print IMG_DIR . $value["image_name"]; ?>" alt="<?php print $value["product_name"]; ?>">
                    </td>
                    <td><?php print $value["price"]; ?>円</td>
                    <td><?php print ($value["stock_qty"] === "0") ? "売り切れ" : "販売中"; ?>
                        <br>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $value["product_id"]; ?>">
                            <?php print ($value["stock_qty"] === "0") ? '<br>' : '<input type="number" name="product_qty" value="1" min="1" required>'; ?>
                            <input type="hidden" name="action" value="add">
                            <?php ($value["stock_qty"] === "0") ? "" : print '<input type="submit" value="カートに入れる">'; ?>
                        </form>
                        <?php if ($value["stock_qty"] < 20 && $value["stock_qty"] > 0): ?>
                            <p class="low-stock">残り少なくなっています<br>
                                在庫<?php print ($value['stock_qty']); ?>個</p>
                        <?php endif; ?>
                    </td>
                </tr>
        <?php } ?>
    </table>
<?php endif; ?>