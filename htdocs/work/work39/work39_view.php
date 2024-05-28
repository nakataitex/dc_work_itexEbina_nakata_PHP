<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try56</title>
    <link rel="stylesheet" href="work39_ec_site_style.css">
</head>

<body>
    <div class="image_sharing">
        <h1>画像投稿</h1>
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
        <form method="post" enctype="multipart/form-data">
            タイトル：<input type="text" name="image_name"><br>
            画像を選択：<input type="file" name="picture"><br>
            公開<input type="radio" name="status" value="public"><br>
            非公開<input type="radio" name="status" value="private" checked><br>
            <input type="submit" value="送信" name="share">
        </form>
    </div>

    <table>
        <tr>
            <caption>画像一覧</caption>
            <th>画像タイトル</th>
            <th>公開・非公開の判定</th>
            <th>投稿日</th>
            <th>更新日時</th>
            <th>ファイル名</th>
            <th>更新日</th>
            <th>画像</th>
            <th>切り替え</th>
        </tr>
        <?php
        foreach ($image_data as $value) { ?>
            <?php $public = public_button_and_class($value) ?>
            <tr class="<?php print $public['public_class']; ?>">
                <td><?php print $value["image_name"]; ?></td>
                <td><?php print $value["public_flg"]; ?></td>
                <td><?php print $value["create_date"]; ?></td>
                <td><?php print $value["update_date"]; ?></td>
                <td><?php print $value["file_name"]; ?></td>
                <td><?php print $value["update_date"]; ?></td>
                <td><img src="<?php print $value["dir"]; ?>" alt="<?php print $value["image_name"]; ?>"></td>
                <td><input type="submit" name="" value="<?php print $public['public_message'] ?>"></td>
            </tr>
        <?php 
     } ?>
    </table>
</body>

</html>