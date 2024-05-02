<?php
$error_msg = [];
require("common.php");

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像管理ページ</title>
</head>

<body>

    <!-- 通知メッセージが必要 -->

    <!-- フォーム -->
    <form method="post" enctype="multipart/form-data">
        タイトル<input type="text" name="image_title"><br>
        ファイル<input type="file" name="picture"><br>
        公開<input type="radio" name="status" value="public">
        非公開<input type="radio" name="status" value="private" checked><br>
        <input type="submit" value="投稿" name="share"><br>
    </form>

    <?php
    //mysqliで接続
    if ($db->connect_error) {
        die("データベース接続エラー: " . $db->connect_error);
    }
    if ($db->connect_error) :
        $notifications[] = '<p class="messege">DB接続エラー' . $db->connect_error . '</p><br>';
        exit();
    else :
        $db->set_charset("utf8");
    endif;

    //PDOでDB接続
    /*     $pdo = new PDO("mysql:host=localhost:8889;dbname=image", "root","root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); */




    //投稿
    if ($_SERVER['REQUEST_METHOD'] === 'POST') : //ポスト送信時
        //変数宣言
        $image_title = $_POST['image_title']; //タイトル
        $image_dir = "images/"; //フォルダ
        $file_name = basename($_FILES['picture']['name']); //ファイル名
        $upload_file = $image_dir . $file_name; //画像ファイルのパス
        $status = $_POST['status']; //ラジオボタンのステータスを取得
        if ($status === "public") :
            $public_flg = 1;
        else :
            $public_flg = 0;
        endif;
        $file = $_FILES['picture'];

        //画像が送られてるか
        if (!empty($_POST["image_title"])) : //タイトル送信時
            if (is_uploaded_file($_FILES['picture']['tmp_name'])) : //画像も送信
                //ファイル形式確認
                if ($file["type"] === "image/jpeg" || $file["type"] === "image/png") :
                    $success = move_uploaded_file($_FILES['picture']['tmp_name'], $upload_file);
                    if ($success) { //ファイル移動
                        echo "ファイルアップロード成功";
                        //投稿
                        $db->begin_transaction(); //トランザクション開始
                        try {
                            $insert = "INSERT INTO share(
                            image_title,
                            public_flg,
                            file_name
                            )             
                            VALUES(
                                ?,
                                ?,
                                ?
                            )";
                            $stmt = $db->prepare($insert); //プリペア使ってSQL実行
                            $stmt->bind_param("sis", $image_title, $public_flg, $file_name); //「?」に代入
                            //クエリ実行
                            $ret = $stmt->execute();

                            if ($ret) : //実行出来たら
                                $db->commit();
                                echo "画像のアップロードと投稿に成功しました。";
                            else :
                                echo $db->error;
                            endif;
                        } catch (Exception $e) {
                            //エラー時にロールバック
                            $db->rollback();
                            echo "error:" . $e->getMessage();
                        }
                    } else {
                        echo "アップロードに失敗しました";
                    }
                else :
                    echo "jpgかpngファイルを選択してください。";
                endif;
            else: //画像が送信されてない
                echo "画像が送信されていません。";
            endif;
        else: //タイトルが送信されてない
            if (is_uploaded_file($_FILES['picture']['tmp_name'])) : //画像だけ送信
                if ($file["type"] === "image/jpeg" || $file["type"] === "image/png") :
                    echo "タイトルが入力されていません。";
                else :
                    echo "ファイル形式が不正です。また、タイトルが入力されていません。";
                endif;
            elseif ($_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE) : //画像も送信されてない
                echo "タイトルを入力し、画像を送信してください。";
            endif;
        endif;
    endif;


    ?>
</body>

</html>