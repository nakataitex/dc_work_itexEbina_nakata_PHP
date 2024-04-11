<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        タイトル<br><input type="text" name="title"><br>
        書き込み内容<br><input type="text" name="text"><br>
        添付画像<br><input type="file" name="upload_image">
        <input type="submit" value="送信">
        <?
        $title = $_POST['title'];
        $text = $_POST['text'];
        $image = $_POST['image'];
        //書き込み
        if ($_POST["title"] != '' || $_POST["text"] != ''):
            $fw = fopen("work20.txt", "a");
            fseek($fw, 0, SEEK_END);
            fwrite($fw, 'タイトル：' . $title . '内容：' . $text . '\n');
            fclose($fw);
            //画像書き込み
            if (isset($_FILES['upload_image'])):

                $save = 'img/' . basename($_FILES['upload_image']['name']);

                if (move_uploaded_file($_FILES['upload_image']['tmp_name'], $save))://アップロード成功
                    $filename = $_FILES['upload_image']['name'];
                    $fp = fopen("imgrecord.txt", 'a');
                    fseek($fp, 0, SEEK_END);
                    fwrite($fp, $filename . '\n');
                    fclose($fp);
                    echo $filename . 'をアップロード成功';
                else://アップロード失敗
                    echo 'アップロード失敗';
                endif;
            endif;
        else:
            echo "<p>入力情報が不足しています</p>";
        endif;


        //読み込み
        
        //テキスト読み込み
        $fr = fopen("work20.txt", "r");
        $list = fgets($fr);
        $list1 = explode('\n', $list);
        $list_reverse = array_reverse($list1, true);
        echo "<p>";
        foreach ($list_reverse as $extract):
            echo htmlspecialchars($extract, ENT_QUOTES) . '<br>';
        endforeach;
        echo "</p>";
        fclose($fr);
        //画像読み込み
        if (file_exists("imgrecord.txt"))://ファイルがあるか確認
            $image_read = fopen("imgrecord.txt", "r");
            $list = fgets($image_read);
            $image_array = explode('\n', $list);//「\n」で区切り配列に格納
            $list_reverse = array_reverse($image_array, true);//配列番号をそのままに並び替えて降順から並べる
            $image_directory = "img/";

            echo "イメージレコードがある<br";
            while($line = fgets($image_read)):
                echo nl2br(htmlspecialchars($line));
                echo "whileは動作してる<br>";
                //正規表現を使って画像パスを抽出
      //          if(preg_match('/画像：\s*(img\/[^\s]+)/', $line, $matches)):
                    $image_path = trim($matches[1]);//パス抽出
                    echo "while内のif1は動いてる<br>";
                    if(file_exists($image_path)):
                        echo "while内のif2は動いてる<br>";
                        echo "<img src='$image_path' style='max-width: 200px;'><br>";
                    endif;
    //            endif;
            endwhile;
            fclose($image_read);
        endif;
               /*  $image_url = $_SERVER['HTTP_HOST'] . '/' .  $image_directory .'/'. realpath($extract);
                echo '<li><img src="' . $image_url . '" alt="' . $extract . '"></li>';
                echo "これがイメージURLです。$image_url<br>";
                echo 'これはエクストラクトrealpath()関数を使用'.realpath($extract).'<br>';
                echo "これはエクストラクト$extract<br>";
                echo "これはイメージディレクトリ$image_directory<br>";
                echo 'これは'.$_SERVER['HTTP_HOST'].'。。。。ここまでS_SERVERのアドレス</br></p>';
            endforeach;
            echo "</ul>";
            echo $image_url = $_SERVER['HTTP_HOST'];
            fclose($fr); */ 

        ?>
    </form>
</body>

</html>