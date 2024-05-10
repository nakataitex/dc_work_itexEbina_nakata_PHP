<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try56</title>
    <link rel="stylesheet" href="ec_product_list_style.css">
</head>

<body>
    <div class="image_sharing">
        <h1>商品管理ページ</h1>
        <?php
        //通知の表示
        if ($msgs) {
            foreach ($msgs as $msg) {
                echo '<p class ="notification">' . $msg . '</p>';
            }
        }
        if ($errors) {
            foreach ($errors as $error) {
                echo '<p class ="error">' . $error . '</p>';
            }
        }
        ?>
        <!-- 未実装
        <form method="post" enctype="multipart/form-data">
            商品名：<input type="text" name="image_name"><br>
            価格：<input type="text" name="price">
            画像を選択：<input type="file" name="picture"><br>
            公開<input type="radio" name="status" value="public"><br>
            非公開<input type="radio" name="status" value="private" checked><br>
            <input type="submit" value="登録" name="share">
        </form>
         -->
    </div>

    <table>
        <tr>
            <caption>商品一覧</caption>
            <th>商品名</th>
            <th>作成日</th>
            <th>画像</th>
            <th>在庫数</th>
            <th>価格</th>
            <th>状態の切替</th>
        </tr>
        <?php
        foreach ($product_view_data as $value) { ?>
            <?php $public = public_button_and_class($value) ?>
            <tr class="<?php print $public['public_class']; ?>">
                <td><?php print $value["product_name"]; ?></td>
                <td><?php print $value["create_date"]; ?></td>
                <td><img src="<?php print $value["dir"]; ?>" alt="<?php print $value["image_name"]; ?>"></td>
                <td><?php print $value["stock_qty"]; ?>個</td>
                <td><?php print $value["price"]; ?>円</td>
                <td><input type="submit" name="" value="<?php print $public['public_button'] ?>"></td>
            </tr>
        <?php
        } ?>
    </table>
</body>

</html>