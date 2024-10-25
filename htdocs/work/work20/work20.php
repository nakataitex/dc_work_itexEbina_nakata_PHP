<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work20</title>
    <style>
        img {
            height: auto;
            width: 200px;
        }
    </style>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <p>タイトルと書き込み内容を入力し、画像を選択して投稿</p><br>
        <p>タイトル</p><input type="text" name="title" required>
        <p>書き込み内容</p><input type="text" name="text" required>
        <p>画像</p><input type="file" name="img" required>
        <input type="submit" value="送信">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST"):
            $title = $_POST['title'];
            $text = $_POST['text'];
            $img_path = 'img/' . basename($_FILES['img']['name']); //保存先
            if (move_uploaded_file($_FILES['img']['tmp_name'], $img_path)): //アップロードしてみて成功したら(true/false)
                //テキスト投稿の情報
                $fw = fopen("work20.txt", "a");
                fseek($fw, 0, SEEK_END);
                fwrite($fw, 'タイトル：' . $title . '内容：' . $text . '\n');
                fclose($fw);
                //画像投稿の情報
                $filename = $_FILES['img']['name']; //ファイル名
                $fp = fopen("imgrecord.txt", 'a');
                fseek($fp, 0, SEEK_END);
                fwrite($fp, $filename . '\n');
                fclose($fp);
                echo $filename . 'をアップロード成功<br>';
                echo '<img src="' . $img_path . '" alt="">';
            else: //アップロード失敗
                echo 'アップロード失敗<br>';
            endif;
        else:
                echo "<br>タイトルと書き込み内容を入力し、画像選択して投稿してください。";
        endif;


        //書き込み内容出力
        $text_read = fopen("work20.txt", "r"); //文字管理テキストファイルを開く
        $img_read = fopen("imgrecord.txt", "r"); //画像管理テキストファイルを開く
        $text_list = fgets($text_read); //文字内容を取得
        $img_list = fgets($img_read); //画像内容を取得
        $text_array = explode('\n', $text_list); //　\n毎に配列を作成
        $img_array = explode('\n', $img_list); //　\n毎に配列を作成
        $text_list_reverse = array_reverse($text_array, true); //配列番号そのままで降順に並び替え
        $img_list_reverse = array_reverse($img_array, true); //配列番号そのままで降順に並び替え
        $dir = "img/";
        if (file_exists("imgrecord.txt") && file_exists("work20.txt")): //ファイルがあるなら
            echo "<br>リストを読み込み成功<br>";
            $list_count = count($text_array);
            for ($i = 0; $i < $list_count; $i++):
                echo '<p>' . $text_list_reverse[$i] . '</p>';
                echo '<img src="./img/' . $img_list_reverse[$i] . '" alt="' . $img_list_reverse[$i] . '"><br>';
            endfor;

        endif;
        fclose($text_read);
        fclose($img_read);

        ?>
    </form>
</body>

</html>