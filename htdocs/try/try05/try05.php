<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY05</title>
</head>
<body>
    <?php 
        $add = 10;
        print '<p>$add : '.$add.'</p>';
        // 値を加算して変数に代入
        $add += 2; 
        print '<p>$add += 2 : '.$add.'</p>'; 

        $test = 100;
        print "<p>てすと＝".$test."</p>";
        $test -= 3;
        print "<p>てすとから3引くと".$test."</p>";

        
    ?>
</body>
</html>