<?php
//SQLの値を割当てるファンクション
function SQL($bind_values, $db)
{
    foreach ($bind_values as $value1 => $value2) {
        $db->bindValue($value1, $value2);
    }
}
;


//DB接続情報
$host_dbname = 'mysql:host=localhost;dbname=xb513874_u338x';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$msgs = [];
$errors = [];

//日付取得
date_default_timezone_set("Asia/Tokyo");
$date = date("Y-m-d");





if ($_SERVER["REQUEST_METHOD"] === "POST"): //ポスト押されたら
    if (isset($_POST["share"])):
        /* 画像投稿機能 */
        if (!empty($_POST["image_name"])):
            if (is_uploaded_file($_FILES["picture"]["tmp_name"])): //両方送信した場合
                if ($_FILES["picture"]["type"] === "image/jpeg" || $_FILES["picture"]["type"] === "image/png"): //拡張子の確認
                    //変数
                    $image_name = $_POST["image_name"]; //画像タイトル
                    $file_name = $_FILES["picture"]["name"]; //ファイル名
                    $file_path = 'img' . $file_name; //ファイルパス

                    //公開・非公開の判定
                    $status = $_POST['status']; //ラジオボタンのステータスを取得
                    if ($status === "public"):
                        $public_flg = 1;
                    else:
                        $public_flg = 0;
                    endif;

                    //画像投稿の処理開始
                    try {
                        //接続
                        $pdo = new PDO($host_dbname, $login_user, $password);
                        //エラー時にPDOExceptionにエラーを投げる
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->beginTransaction(); //トランザクション開始
                        //挿入のSQL文
                        $insert = 'INSERT INTO 
                    image_sharing (
                        image_name,
                        create_date,
                        file_name,
                        public_flg
                    ) 
                    VALUES(
                        :image_name,
                        :create_date,
                        :file_name,
                        :public_flg
                    )';
                        //プリペア
                        $stmt = $pdo->prepare($insert);
                        //挿入に使う値
                        $insert_values = [
                            ":public_flg" => $public_flg,
                            ":create_date" => $date,
                            ":file_name" => $file_name,
                            ":image_name" => $image_name
                        ];
                        //値の割当
                        SQL($insert_values, $stmt);
                        //実行
                        $result = $stmt->execute();
                        //ファイル操作
                        $file_path = 'img/' . basename($_FILES['picture']['name']);
                        $file_move = move_uploaded_file($_FILES['picture']['tmp_name'], $file_path);
                        if ($file_move):
                        else:
                            array_push($errors, '<p class="message">ファイルのアップロード失敗</p>');
                        endif;
                        if ($result && $file_move) {
                            $pdo->commit();
                            array_push($msgs, "投稿完了");
                        } else {
                            array_push($errors, "ファイルのアップロードに失敗しました。");
                        }
                    } catch (PDOException $e) {
                        array_push($errors, "エラー：$e<br>");
                        $pdo->rollBack();
                    }
                else:
                    array_push($errors, "ファイル形式が不正です");
                endif;
            else:
                array_push($errors, "画像が選択されていません。");
            endif;
        else:
            if (is_uploaded_file($_FILES["picture"]["tmp_name"])): //画像だけ添付
                array_push($errors, "タイトルが入力されていません。");
            else:
                array_push($errors, "タイトルを入力して画像を選択してください。");
            endif;
        endif;
    endif;

    //画像の公開切り替え
    if (isset($_POST["image_id"])): //公開/非公開を押したら
        $get_id = $_POST['image_id'];
        try {
            //接続
            $pdo = new PDO($host_dbname, $login_user, $password);
            //エラー時にPDOExceptionにエラーを投げる
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->beginTransaction(); //トランザクション開始
            //更新のSQL文
            $public_change =
                'UPDATE 
                    image_sharing 
                SET 
                public_flg = 1 - public_flg ,update_date = :update_date
                WHERE 
            image_id = :image_id';
            //プリペア
            $stmt = $pdo->prepare($public_change);
            //更新に使う値
            $update_values = [
                ":image_id" => $get_id,
                ":update_date" => $date
            ];
            //値の割当
            SQL($update_values, $stmt);
            //実行
            $public_change_result = $stmt->execute();
            if ($public_change_result) {
                $pdo->commit();
                array_push($msgs, "表示/非表示の切り替え完了");
            } else {
                array_push($errors, "表示の切り替えに失敗しました");
            }
        } catch (PDOException $e) {
            array_push($errors, "エラー：$e");
            $pdo->rollBack();
        }
    endif;

endif;


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work36</title>
</head>
<style>
    .error {
        color: red;
    }

    .image_tile {
        width: 300px;
        height: 300px;
        box-sizing: content-box;
        margin: 0 auto;
        line-height: 1.5;
    }

    img {
        height: auto;
        width: 100px;
    }

    .image_list {
        display: flex;
        list-style: none;
    }

    .private {
        background-color: grey;
    }
</style>

<body>


    <h1>画像投稿</h1>
    <?php
    //通知の表示
    var_dump($msgs);
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
    <!-- フォーム -->
    <form method="post" enctype="multipart/form-data">
        タイトル：<input type="text" name="image_name"><br>
        画像を選択：<input type="file" name="picture"><br>
        公開<input type="radio" name="status" value="public"><br>
        非公開<input type="radio" name="status" value="private" checked><br>
        <input type="submit" value="送信" name="share">
    </form>


    <!-- 画像一覧の閲覧機能 -->
    <ul class="image_list">
        <?php
        //登録された画像のデータを取得
        try {
            //接続
            $pdo = new PDO($host_dbname, $login_user, $password);
            //エラー時にPDOExceptionにエラーを投げる
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //挿入のSQL文
            $select = "SELECT * FROM image_sharing";
            $image_manage_result = $pdo->query($select); //クエリ実行
            //ファイル操作
            $img_dir = "./img/";
            $images = [];
            while ($row = $image_manage_result->fetch()): //imagesに格納
                $images[] = $row;
            endwhile;
        } catch (PDOException $e) {
            array_push($errors, "エラー：$e<br>");
        }

        //表示切り替えのボタン
        foreach ($images as $image):
            switch ($image["public_flg"]):
                case 1:
                    $public_message = "非表示にする";
                    $public_class = "public";
                    break;
                case 0:
                    $public_message = "表示する";
                    $public_class = "private";
                    break;
                default:
                    $public_message = "ステータス異常(非公開にする)";
                    $public_class = "private";
                    break;
            endswitch;
            ?>
            <!-- 各画像の項目 -->
            <li class="image_tile <?php echo $public_class; ?>">
                <form method="post">
                    <input type="hidden" name="image_id" value="<?php echo $image['image_id']; ?>">
                    <?php echo $image['image_id']; ?>
                    <p>タイトル：<?php echo htmlspecialchars($image['image_name']); ?></p>
                    <p>ファイル名：<?php echo htmlspecialchars($image["file_name"]); ?></p>
                    <p>投稿日：<?php echo $image["create_date"]; ?></p>
                    <p>更新日：<?php echo $image["update_date"]; ?></p>
                    <img src="<?php echo $img_dir . $image['file_name']; ?>" alt="<?php echo $image["image_name"]; ?>">
                    <input type="submit" value="<?php echo $public_message; ?>" name="public_change">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <br>
    <a href="image_list.php">閲覧画面へ移動</a>
</body>

</html>