<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        タイトル<br><input type="text" name="title"><br>
        書き込み内容<br><input type="text" name="text"><br>
        <input type="submit" value="送信">
        <?
        $title = $_POST['title'];
        $text = $_POST['text'];
        //書き込み
        if (!empty($_POST)):
            if ($_POST["title"] != '' || $_POST["text"] != ''):
                $fw = fopen("work19.txt", "a");
                fseek($fw, 0, SEEK_END);
                fwrite($fw, 'タイトル：' . $title . '内容：' . $text . '\n');
                fclose($fw);
            else:
                echo "<p>入力情報が不足しています</p>";
            endif;
        endif;
        //読み込み
        $fr = fopen("work19.txt", "r");
        $list = fgets($fr);
        $list1 = explode('\n', $list);
        $list_reverse = array_reverse($list1, true);
        echo "<p>";
        foreach ($list_reverse as $extract):
            echo htmlspecialchars($extract, ENT_QUOTES) . '<br>';
        endforeach;
        echo "</p>";
        fclose($fr);
        ?>
    </form>
</body>

</html>