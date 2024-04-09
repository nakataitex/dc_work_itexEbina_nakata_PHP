<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
 //   $t1 = 1;
 //   $t2 = 1;
 //   $t3 = 0;
        // iが1から始まり、10以下の間繰り返し処理を行う
        while ($t1 <= 10){
            switch($t1):
                case ($t1 % 2 == 0):
                    $t2 .= '*';
                    echo '<p>'.$t2.'</p>';
                    break;
                default:
                    $t3 .= '!';
                    echo '<p>'.$t3.'</p>';
                endswitch;
                $t1++;
        };
    ?>
</body>
</html>