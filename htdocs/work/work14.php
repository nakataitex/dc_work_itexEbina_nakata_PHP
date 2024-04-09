<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
      $i=0;
        $num = array();
        while ($i <= 100):
            array_push($num, $i);
            if($i % 2 == 0):
                echo '<p>'.$num[$i].'は偶数である</p>';
            else:
                echo '<p>'.$num[$i].'は奇数である</p>';
            endif;
                $i++;
            endwhile;
    ?>
</body>
</html>