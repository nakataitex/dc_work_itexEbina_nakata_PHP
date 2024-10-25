<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>TRY13</title>
</head>

<body>
    <?php
    $score = rand(0, 100);
    $s = 3;
    print '<p>' . $score . '</p>';
    switch ($score) {
        case ($score % 3 == 0 && $score % 6 == 0):
            echo "<p>これは3と6の倍数</p>";
            break;
        case ($score > 0):
            echo "<p>これは3の倍数ではない</p>";
            break;
        case ($score % 3 == 0 && $score % 6 !== 0):
            echo "<p>これは3の倍数で、6の倍数ではない</p>";
            break;
    }

    $random = rand(0, 4);		// 0～4までのランダムな数値を取得
    print '<p>$random: ' . $random . '</p>';

    switch ($random) {
        case 1:
            print '<p>変数$randomの値は1です。 </p>';
            break;	//switch文の処理を終了する
        case 2:
            print '<p>変数$randomの値は2です。 </p>';
            break; 	//switch文の処理を終了する
        default:
            print '<p>変数$randomの値は1,2ではありません。 </p>';
    }
    ?>
</body>

</html>