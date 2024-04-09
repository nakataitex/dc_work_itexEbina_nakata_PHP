<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
    $a = 0;
    $b = 1;
    $c = 0;
        // iが1から始まり、10以下の間繰り返し処理を行う
        for ($a = 1; $a <= 9; $a++){
            for($b = 1; $b <= 9; $b++){
                $c = $a * $b;
                echo '<p>'.$a.'X'.$b.' ='.$c.'</p>';
            };
        };
    ?>
</body>
</html>