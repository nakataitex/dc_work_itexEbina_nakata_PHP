<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像一覧</title>
</head>

<style>
    img {
        width: 200px;
        max-height: 200px;
        object-fit: cover;
    }

    .image_list {
        display: flex;
        justify-content: space-around;
        max-width: 1000px;
        font-size: 13px;
    }

    .image_tile {
        width: 300px;
        height: 300px;
        border: solid;
        list-style: none;
    }
</style>

<body>
    <?php
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_error):
        echo "DB接続エラー$db->connect_error";
        exit();
    else:
        $db->set_charset("utf8");
    endif;

    $sql = "SELECT
        image_id,
        image_name,
        public_flg,
        create_date,
        update_date,
        file_name
        FROM
        image_sharing

        WHERE
        public_flg = 1;
    ";
    $result = $db->query($sql);//クエリ実行
    $img_dir = "./img/";
    $images = array();
    while ($row = $result->fetch_assoc())://imagesに格納
        $images[] = $row;
    endwhile;
    ?>
        <ul class="image_list">
            <?
            foreach ($images as $image):
                if ($image['public_flg'] == 1):
                    echo '<li class="image_tile">タイトル：' . $image["image_name"] . '<br>ファイル名：' . $image["file_name"] . '<br>
            <img src="' . $img_dir . $image['file_name'] . '" alt="' . $image_name . '"></li>';
                endif;
            endforeach;
            ?>
            <br>
        </ul>
    <a href="./upload.php">画像投稿ページへ移動</a>


</body>

</html>