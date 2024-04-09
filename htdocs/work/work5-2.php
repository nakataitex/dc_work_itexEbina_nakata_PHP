<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY10</title>
</head>
<body>
    <?php
    $score1 = rand(1,10);
    $score2 = rand(1,10);
    echo '<p>score1は'.$score1.'</p>';
    echo '<p>score2は'.$score2.'</p>';
    $counter = 0;
    if($score1 % 3 == 0){
        $counter ++;
    };
    if($score2 % 3 == 0){
        $counter ++;
    };
    if($counter == 1){
        $result = '2つの数字には'.$counter.'つ3の倍数がある';
    };
    if($score1 >= $score2){
        echo '<p>score1の方が大きな数。</p>';
        if($counter >= 1){
            echo $result;
        }
    }else if($score1 == $score2){
            echo "<p>score1と2は等しい</p>" ;
        } else {
            echo '<p>score2の方が大きな数。</p>';
            if($counter >= 1){
                echo $result;
            }
        };
    ?>
</body>
</html>