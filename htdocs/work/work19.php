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
        //ファイルの書き込み
/* 
         $fw = fopen("work19.txt", "w");
        fseek($fw, 0, SEEK_END);
        fwrite($fw, 'タイトル：'.htmlspecialchars($title, ENT_QUOTES) . '内容：' . htmlspecialchars($text, ENT_QUOTES) . '\n');
        fclose($fw);  */
        //読み込み(多分機能実装完了)
        $fr = fopen("work19.txt", "r");
        $list = fgets($fr);
        $list1 = explode('\n', $list);
        echo "<p>";
        print_r($list1);
        foreach ($list1 as $extract):
            echo $extract.'<br>';
        endforeach;
        echo "</p>";
        fclose($fr);
/*         if ($count > 0):
            $viewcount = $count + 1;
        endif;
        echo '<p>行数:' . $viewcount . '</p>';
 */

        /* 

            if(isset($_POST['title']) && $_POST['title'] !=''):
                echo '<p>'.htmlspecialchars($title, ENT_QUOTES).'</p>';
                if(isset($_POST['text']) && $_POST['text'] !=''):
                    echo '<p>'.htmlspecialchars($text, ENT_QUOTES).'</p>';
                else:
                    echo "<p>書き込み内容が入力されていません。</p>";
                endif;
            else:

                if(isset($_POST["text"]) && $_POST["text"] !=''):
                    if(isset($_POST['text']) && $_POST['text'] !=''):
                        echo "'<p>タイトルが入力されていません。<p>";
                        echo '<p>'.htmlspecialchars($text, ENT_QUOTES).'</p>';
                    else:
                        echo '<p>入力情報が不足しています</p>';
                    endif;
            endif; */

        ?>
    </form>
</body>

</html>