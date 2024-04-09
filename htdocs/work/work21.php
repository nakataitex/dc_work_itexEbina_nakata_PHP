<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work21</title>
</head>

<body>
    <?php
    $text = '';
    $text2 = '';

    if (isset($_POST['text'])):
        $text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');
    endif;
    if (isset($_POST['text2'])):
        $text2 = htmlspecialchars($_POST['text2'], ENT_QUOTES, 'UTF-8');
    endif;
    ?>
    <form method="post">
        インプット1<input type="text" name="text"><br>
        インプット2 <input type="text" name="text2"><br>
        <input type="submit" name="送信"><br>
    </form>
    <?php
    echo "<p>";
    if (!preg_match("/^[a-zA-Z]+$/", $text) && $text !== ''):
        echo "正しい文字ではありません";
    elseif (preg_match("/dc/", $text)):
        echo "ディーキャリアが含まれています";
    elseif (preg_match("/end/", $text)):
        echo "終了です！";
    elseif ($text == ''):
        echo "半角英数が入力されていません。";
    else:
        echo "正常に入力されました";
    endif;
    echo "<br>";
    if (!preg_match("/^(090|080|070)-[0-9]{4}-[0-9]{4}+$/", $text2) && $text2 !== ""):
        echo "正しい携帯電話の形式ではない";
    elseif ($text2 == ''):
        echo "電話番号が入力されていません。";
    else:
        echo "正しい携帯電話番号形式です。";
        echo "</p>";
    endif;

    ?>
</body>

</html>