<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
 //   $t1 = 0;
 //   $t2 = 0;
 //   $t3 = 0;
        // iが1から始まり、10以下の間繰り返し処理を行う
        for ($t1 = 1; $t1 <= 10; $t1++):
            switch($t1):
                case ($t1 % 2 == 0):
                    $t2 .= '*';
                    echo '<p>'.$t2.'</p>';
                    break;
                default:
                    $t3 .= '!';
                    echo '<p>'.$t3.'</p>';
                endswitch;
            endfor;
    ?>
</body>
</html>