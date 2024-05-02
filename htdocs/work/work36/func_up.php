<?php

require("common.php");

$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
$error_view = [];
$notifications = [];

//作成日、更新日管理
/* date_default_timezone_set('Asia/Tokyo');
$date = date("Y-m-d H:i:s");
 */

//作成日、更新日管理
date_default_timezone_set('Asia/Tokyo');
$date = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work35</title>
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

    /*     .img_share {
        position: relative;
    }

    .messege {
        position: absolute;
        top: 30px;
    } */

    .form {
        margin: 50px;
    }

    .img_manager {
        margin: 50px;
    }
</style>

<body>
    <h1>画像投稿</h1>
    <!-- フォーム -->
    <div class="form">
        <form method="post" enctype="multipart/form-data">
            タイトル<input type="text" name="image_title"><br>
            ファイル<input type="file" name="picture"><br>
            公開<input type="radio" name="status" value="public" checked>
            非公開<input type="radio" name="status" value="private"><br>
            <input type="submit" value="投稿" name="share"><br>
        </form>
    </div>

    <?php
    //公開・非公開の判定
    $status = $_POST['status'];//ラジオボタンのステータスを取得
    if ($status === "public"):
        $public_flg = 1;
    else:
        $public_flg = 0;
    endif;

    //SQLにログイン(OK)
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_error):
        echo '<p class="messege">DB接続エラー' . $db->connect_error . '</p><br>';
        exit();
    else:
        $db->set_charset("utf8");
    endif;


    //投稿
    if ($_SERVER['REQUEST_METHOD'] === 'POST'): //ポスト送信時
        //変数宣言
        $image_title = $_POST['image_title']; //タイトル
        $image_dir = "img/"; //フォルダ
        $file_name = basename($_FILES['picture']['name']); //ファイル名
        $upload_file = $image_dir . $file_name; //画像ファイルのパス
        $status = $_POST['status']; //ラジオボタンのステータスを取得
        if ($status === "public"):
            $public_flg = 1;
        else:
            $public_flg = 0;
        endif;
        $file = $_FILES['picture'];

        //画像が送られてるか
        if (!empty($_POST["image_title"])): //タイトル送信時
            if (is_uploaded_file($_FILES['picture']['tmp_name'])): //画像も送信
                //ファイル形式確認
                if ($file["type"] === "image/jpeg" || $file["type"] === "image/png"):
                    $success = move_uploaded_file($_FILES['picture']['tmp_name'], $upload_file);
                    //新規か更新か
                    $update_check = "SELECT * FROM image_name WHERE image_name = '$image_name'";
                    $result = $db->query($update_check);
                    if ($success) { //ファイル移動
                        echo "ファイルアップロード成功";
                        //投稿
                        if ($result->num_rows > 0)://画像タイトルが重複していたら
                            $db->begin_transaction(); //トランザクション開始
                            try {
                                $update = "UPDATE image_sharing SET update_date = date WHERE image_name = ?";
                                $stmt = $db->prepare($update);
                                if (!$stmt) {
                                    die($db->error);
                                }
                                $stmt->bind_param("s", $date); //「?」に代入
                                //クエリ実行
                                $ret = $stmt->execute();
                                if ($ret): //実行出来たら
                                    $db->commit();
                                    echo "画像のアップロードと更新日時を更新しました。";
                                else:
                                    echo $db->error;
                                endif;
                            } catch (Exception $e) {
                                //エラー時にロールバック
                                $db->rollback();
                                echo "error:" . $e->getMessage();
                            }
                        else:
                            $db->begin_transaction(); //トランザクション開始
                            try {
                                $insert = "INSERT INTO image_sharing(
                            image_name,
                            public_flg,
                            file_name
                            ) 
                            VALUES(
                                ?,
                                ?,
                                ?
                            )";
                                $stmt = $db->prepare($insert); //プリペア使ってSQL実行
                                if (!$stmt) {
                                    die($db->error);
                                }
                                $stmt->bind_param("sis", $image_title, $public_flg, $file_name); //「?」に代入
                                //クエリ実行
                                $ret = $stmt->execute();

                                if ($ret): //実行出来たら
                                    $db->commit();
                                    echo "画像のアップロードと投稿に成功しました。";
                                else:
                                    echo $db->error;
                                endif;
                            } catch (Exception $e) {
                                //エラー時にロールバック
                                $db->rollback();
                                echo "error:" . $e->getMessage();
                            }
                        endif;
                    } else {
                        echo "アップロードに失敗しました";
                    }
                else:
                    echo "jpgかpngファイルを選択してください。";
                endif;
            else: //画像が送信されてない
                echo "画像が送信されていません。";
            endif;
        else: //タイトルが送信されてない
            if (is_uploaded_file($_FILES['picture']['tmp_name'])): //画像だけ送信
                if ($file["type"] === "image/jpeg" || $file["type"] === "image/png"):
                    echo "タイトルが入力されていません。";
                else:
                    echo "ファイル形式が不正です。また、タイトルが入力されていません。";
                endif;
            elseif ($_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE): //画像も送信されてない
                echo "タイトルを入力し、画像を送信してください。";
            endif;
        endif;
    endif;


    //画像表示
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
                    <form method="post" action ="func_up.php">
                    <input type="hidden" name="image_id" value="' . $image['image_id'] . '">
                    タイトル：' . htmlspecialchars($image["image_name"]) . '
                <p>ファイル名：' . $image["file_name"] . '</p>
                <img src="' . $img_dir . $image['file_name'] . '" alt="' . $image_title . '">
                <input type="submit" value = "' . $public_messege . '" name="public_change">
                </form>
                </li>';
        endforeach;

        //画像の公開切り替え
        /* if (isset($_POST["image_id"]))://公開/非公開を押したら
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
                $notifications[] = '<p class="messege">エラーが発生した為作業を取り消します。</p><br>';
                $db->rollback();
            else://成功時の処理
                $notifications[] = '<p class="messege">' . $row . ' 件の切り替えに成功しました。<br>切り替えた画像のID: ' . $get_image_id;
                $db->commit();
                //var_dump($error_msg);
            endif;
        endif; */


        //ファンクション



        ?><br><br>
        <a href="image_view.php">画像一覧ページへ移動</a>
</body>

</html>