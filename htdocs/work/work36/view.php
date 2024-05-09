<?php
//DB接続情報
$host_dbname = 'mysql:host=localhost;dbname=xb513874_u338x';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        .error {
        color: red;
    }

    .image_tile {
        width: 300px;
        height: 300px;
        box-sizing: content-box;
        margin: auto;
        border: 4px solid;
    }

    img {
        height: auto;
        width: 100px;
    }

    .image_list {
        width: 1080px;
        display: flex;
        list-style: none;
    }

    .private {
        background-color: grey;
    }
</style>
<body>
    <!-- 画像一覧の閲覧機能 -->                                          
    <ul class="image_list">
        <?php
        try {
            //接続
            $pdo = new PDO($host_dbname, $login_user, $password);
            //エラー時にPDOExceptionにエラーを投げる
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction(); //トランザクション開始
            //挿入のSQL文
            $select = "SELECT * FROM image_sharing WHERE public_flg = 1";
            $image_manage_result = $pdo->query($select); //クエリ実行
            //ファイル操作
            $img_dir = "./img/";
            $images = [];
            while ($row = $image_manage_result->fetch()) : //imagesに格納
                $images[] = $row;
            endwhile;
        } catch (PDOException $e) {
            array_push($errors, "エラー：$e<br>");
            $pdo->rollBack();
        }
        foreach ($images as $image) :
        ?><li class="image_tile <?php echo $public_class; ?>">
                    <p>タイトル：<?php echo htmlspecialchars($image["image_name"]); ?></p>
                    <p>投稿日：<?php echo $image["create_date"]; ?></p>
                    <p>更新日：<?php echo $image["update_date"]; ?></p>
                    <img src="<?php echo $img_dir . $image['file_name']; ?>" alt="<?php echo $image["image_name"]; ?>">
            </li>
        <?php endforeach;
        ?>
        <a href="upload.php">管理画面へ移動</a>
</body>
</html>