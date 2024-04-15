<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像てすと</title>
</head>
<style>
    img {
        width: 30%;
        height: 30%;
    }
</style>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="img">
        <input type="submit" value="送る" name="up">
        <?php
        $img_url = 'http://' . $SERVER['HTTP_HOST'] . '/img/' . $filename;
        if (isset($_POST["up"]))://送信押したら
            echo "送信が押された<br>";
            //画像書き込み
            if (isset($_FILES['img']))://imgが空でなければ
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

        //画像出力
        $img_read = fopen("imgrecord.txt", "r");//画像管理テキストファイルを開く
        $img_list = fgets($img_read);//内容を取得
        $img_array = explode('\n', $img_list);//\n毎に配列を作成
        $img_list_reverse = array_reverse($img_array, true);//配列番号そのままで降順に並び替え
        $dir = "img/";
        if (file_exists("imgrecord.txt"))://ファイルがあるなら
            echo "imgrecord.txtを読み込み成功<br>";
            foreach ($img_list_reverse as $img_filename)://配列を読み込み
                if (!empty($img_filename))://内容があるなら
                echo '<img src="' . $dir . $img_filename . '" alt="' . $img_filename . '">';//画像を表示
                endif;
            endforeach;
        endif;
        fclose($img_read);
        ?>
    </form>
</body>

</html>