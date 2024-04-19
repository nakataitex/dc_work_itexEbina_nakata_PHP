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
    <title>画像投稿ページ</title>
</head>
<style>
    .error {
        color: #100;
    }
</style>

<body>
    <!-- フォーム -->
    <form action="image_view.php" method="post" enctype="multipart/form-data">
        タイトル：<input type="text" name="title"><br>
        画像：<input type="file" name="img"><br>
        <input type="submit" value="投稿" name = "share">
    </form>
    <?php
    //DB接続
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_error):
        echo "DB接続エラー$db->connect_error";
        exit();
    else:
        $db->set_charset("utf8");
        echo "DB接続完了";
    endif;

    //投稿処理
    
    //下の処理を整理した方が良い
    
    /* if(isset($_POST["title"] )): //タイトルが送信されたら
        if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST["title"])&& $_POST["title"] !== "")://正規表現で半角英数かチェック
            echo '<p class="error">半角英数以外が入力されています。</p>';
            exit();
        else($_POST["title"] == "")://タイトルが送信されてない
            echo '<p class="error">画像のタイトルが入力されていません。</p>';
            exit();
        else:
                $img_path = '/img' . basename($_FILES("img","name"));
        if(isset($_POST["img"]))://画像が送信されたら
        else://画像が送信されてない
            echo "画像が選択されていません。";
        endif;
    else://タイトルが入力されてない。
        echo"画像タイトルが入力されていません。";
    endif; */

    $title = $_POST['title'];
    $text = $_POST['text'];
    $img = $_POST['img'];


    if ($title && $img)://タイトルと画像を送信
        if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST["title"]) && $_POST["title"] !== "")://半角英数以外を入力
            echo '<p class="error">半角英数以外が入力されています。</p>';
            exit();
        else://タイトルと半角英数OK
            if (isset($_FILES['img']))://imgが送られたら
                
                $img_path = 'img/' . basename($_FILES['img']['name']);//保存先
                if (move_uploaded_file($_FILES['img']['tmp_name'], $img_path))://アップロードしてみて成功したら(true/false)
                    $filename = $_FILES['img']['name'];//ファイル名
                    $fp = fopen("imgrecord.txt", 'a');
                    fseek($fp, 0, SEEK_END);
                    fwrite($fp, $filename . '\n');
                    fclose($fp);
                    echo $filename . 'をアップロード成功<br>';
                    echo '<img src="' . $img_url . '" alt="">';
                else://アップロード失敗
                    echo 'アップロード失敗<br>';
                endif;
            endif;
        endif;
    elseif ($title && empty($img))://画像なし
        echo '画像が添付されていません<br>';
        exit();
    elseif (empty($title) && $img)://タイトルなし
        echo 'タイトルが入力されていません<br>';
        exit();
    endif;


    ?>
</body>

</html>