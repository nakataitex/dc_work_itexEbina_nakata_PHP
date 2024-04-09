<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
  $a = 1;
    $b = 1;
    $c = 0;
        // iが1から始まり、10以下の間繰り返し処理を行う
        while ($a <= 9){
            while($b <= 9){
                $c = $a * $b;
                echo '<p>'.$a.'X'.$b.' ='.$c.'</p>';
                $b++;
            };
            $a++;
        };
    ?>
</body>
</html>