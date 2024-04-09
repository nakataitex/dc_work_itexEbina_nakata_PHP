<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY10</title>
</head>
<body>
    <?php 
        $score = rand(0,100);		// 0～100までのランダムな数値を取得
        print '<p>$score: '.$score.'</p>'; 
        print '<p>$score == 100 : ';
        var_dump($score == 100);
        print ' </p>';
        print '<p>$score >= 60 : ';
        var_dump($score >= 60);
        print '</p>';
        if ($score == 100) {
            print '<p>満点です。</p>';
        } else if ($score >= 60) {
            print '<p>合格です。</p>';
        } else {
            print '<p>不合格です</p>';
        }

        $tensu = rand(0,1000);
        print "<p>0~1000のランダム出力:$tensu</p>";
        print '<p>0~1000のランダム出力:$tensu</p>';
        print "<p>点数が1000点かどうか";
        var_dump($tensu === 1000);
        print "</p>";
        print "<p>点数が600点以上かどうか";
        var_dump($tensu >=600);
        print "</p>";
        if($tensu >=600){
            echo "<p>合格です</p>";

        }else {
            echo "<p>不合格です</p>";
        }
        ;
    ?>
</body>
</html>