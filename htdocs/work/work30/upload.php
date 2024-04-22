<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
$error_view = [];

//作成日、更新日管理
date_default_timezone_set('Asia/Tokyo');
$date = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
</head>
<style>
    img {
        width: 150px;
        max-height: 150px;
        object-fit: cover;
    }

    .image_list {
        display: flex;
        justify-content: space-between;
        max-width: 800px;
        font-size: 13px;
    }

    .image_tile {
        width: 200px;
        height: 250px;
        border: solid;
        list-style: none;
        box-sizing: border-box;
        vertical-align: middle;
        margin: 0 auto;
    }

    .image_tile li {
        vertical-align: middle;
        margin: 0 auto;
    }

    .private {
        background-color: #7d7d7d;
    }

    .img_share {
        position: relative;
    }

    .messege {
        position: absolute;
        top: 30px;
    }


    .form {
        margin: 50px;
    }

    .img_manager {
        margin: 50px;
    }
</style>

<body>
    <div class="img_share">
        <h1>画像投稿</h1>
        <div class="form">
            <form method="post" enctype="multipart/form-data">
                タイトル<input type="text" name="image_name"><br>
                ファイル<input type="file" name="img"><br>
                公開<input type="radio" name="status" value="public" checked>
                非公開<input type="radio" name="status" value="private"><br>
                <input type="submit" value="投稿" name="share"><br>
            </form>
        </div>

        <div class="img_manager">
            <?php
            //公開・非公開の判定(ここはOK)
            $status = $_POST['status'];//ラジオボタンのステータスを取得
            if ($status === "public"):
                $public_flg = 1;
            else:
                $public_flg = 0;
            endif;

            $image_name = $_POST["image_name"];
            $file_name = $_FILES['img']['name'];



            //SQLにログイン(OK)
            $db = new mysqli($host, $login_user, $password, $database);
            if ($db->connect_error):
                echo '<p class="messege">DB接続エラー' . $db->connect_error . '</p><br>';
                exit();
            else:
                $db->set_charset("utf8");
            endif;

            $img = $_POST['image_title'] ?? '';
            $imgfile = $_FILES['img'] ?? null;

            //画像とタイトルが送信されたら
            if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                if (empty($_POST["image_name"]) && empty($_FILES["img"])):
                    echo '<p class="messege">タイトルを入力し、画像を添付してください。</p>';
                elseif (!empty($_POST['image_name']) && !empty($_FILES['img']))://タイトルと画像送信したら
                    $db->begin_transaction();//トランザクション開始
                    //投稿
                    $insert_query = "INSERT INTO image_sharing(
                            image_name,
                            public_flg,
                            create_date,
                            file_name
                            )
            
                            VALUES(
                                '$image_name',
                                '$public_flg',
                                '$date',
                                '$file_name'
                            )";
                    //実行
                    if ($result = $db->query($insert_query)):
                        $row = $db->affected_rows;
                        //画像のアップロード処理
                        $image_path = 'img/' . basename($_FILES['img']['name']);
                        if (move_uploaded_file($_FILES['img']['tmp_name'], $image_path)):
                        else:
                            echo '<p class="messege">ファイルのアップロード失敗</p>';
                        endif;
                    else:
                        $error_msg[] = 'INSERT実行エラー[実行SQL]' . $insert_query;
                    endif;

                    if (count($error_msg) > 0)://エラー時の処理
                        echo '<p class="messege">画像の投稿に失敗しました';
                        $db->rollback();
                    else://成功時の処理
                        echo '<p class="messege">画像' . $row . '件の投稿に成功しました。<br>ファイル名：.' . $image_name;

                        $db->commit();

                        //                var_dump($error_msg);
                    endif;
                elseif (!empty($_POST["image_name"]) && empty($_FILES["img"])):
                    echo '<p class="messege">画像が添付されていません</p>';
                elseif (empty($_POST["image_name"]) && !empty($_FILES["img"])):
                    echo '<p class="messege">名前が入力されていません</p>';
                endif;
            endif;

            ?>
            <br><?php
            $sql = "SELECT
        image_id,
        image_name,
        public_flg,
        create_date,
        update_date,
        file_name

        FROM
        image_sharing
    ";
            $image_manage_result = $db->query($sql);//クエリ実行
            $img_dir = "./img/";
            $images = array();
            while ($row = $image_manage_result->fetch_assoc())://imagesに格納
                $images[] = $row;
            endwhile;

            ?>

            <ul class="image_list">
                <?php



                foreach ($images as $image):
                    $public_flg = $image['public_flg'];
                    if ($public_flg == 1):
                        $public_messege = "非表示にする";
                        $public_class = "public";
                    else:
                        $public_messege = "表示する";
                        $public_class = "private";
                    endif;
                    echo '<li class="image_tile ' . $public_class . ' ">
                    <form method="post" action ="">
                    <input type="hidden" name="image_id" value="' . $image['image_id'] . '">
                    タイトル：' . $image["image_name"] . '
                <p>ファイル名：' . $image["file_name"] . '</p>
                <img src="' . $img_dir . $image['file_name'] . '" alt="' . $image_name . '">
                <input type="submit" value = "' . $public_messege . '" name="public_change">
                </form>
                </li>';
                endforeach;


                //画像の公開切り替え
                if (isset($_POST["image_id"]))://公開/非公開を押したら
                    $get_image_id = $_POST['image_id'];
                    $db->begin_transaction();//トランザクション開始
                    //公開切り替え
                    $public_change =
                        'UPDATE
        image_sharing
    SET
        public_flg = 1 - public_flg
    WHERE
    image_id = ' . $_POST["image_id"] . ';';
                    //実行
                    if ($public_change_result = $db->query($public_change)):
                        $row = $db->affected_rows;
                        //クエリが実行出来るか
                        //echo "クエリが実行できた<br>";
                    else:
                        $error_msg[] = 'INSERT実行エラー[実行SQL]' . $public_change;
                    endif;

                    if (count($error_msg) > 0)://エラー時の処理
                        echo '<p class="messege">エラーが発生した為作業を取り消します。</p><br>';
                        $db->rollback();
                    else://成功時の処理
                        echo '<p class="messege">' . $row . ' 件の切り替えに成功しました。<br>切り替えた画像のID: ' . $get_image_id;
                        $db->commit();
                        //var_dump($error_msg);
                    endif;
                endif;
                ?>
                <br>
                </form>
            </ul>
        </div>
    </div>
    <a href="./image_view.php">画像一覧ページへ移動</a>

</body>

</html>