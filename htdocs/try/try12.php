<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY12</title>
</head>
<body>
    <?php 
        $score = rand(0,100);	// 0～100までのランダムな数値を取得　
    ?>
    <p>$score: <?php echo $score ?></p> 
    <p>$score == 100: <?php var_dump($score == 100); ?></p>
    <p>$score >= 60: <?php var_dump($score >= 60); ?></p>
    <?php if ($score == 100): ?>
        <p>満点です。</p>
    <?php elseif ($score >= 60): ?>
        <p>合格です。</p>
    <?php else: ?>
        <p>不合格です</p>
    <?php endif; ?>


    <?php
    $score1 = rand(0,1000);
    $score2 = rand(0,1000);
    $result = 0;
    ?>
    <p>score1: <?php echo $score1 ?></p>
    <p>score2: <?php echo $score2 ?></p>
    <?php
    if($score1 > $score2):
        $result = 1;
        elseif($score1 < $score2):
            $result = 2;
        endif;
    if($result == 0):?>
        <p>２つの数字は等しいです。</p>;
        <?php
        else:
            echo '<p>score'.$result.'の方が大きいです';
        endif;?>
</body>
</html>