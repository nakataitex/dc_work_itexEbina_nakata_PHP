<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY10</title>
</head>
<body>
    <?php 
    $score = rand(0,100);
    print ?><p><?php$score?></p>;
<?php    
if ($score % 3 == 0 && $score % 6 == 0){
        echo ?>
        <p>3の倍数かつ6の倍数。</p>;
    <?php
    } else if($score % 3 == 0){
        echo 
        ?>
        <p>3の倍数で、6の倍数ではありません</p>;
    <?php
} else{
        echo ?><p>3の倍数ではない</p>;
<?php
}
?>
</body>
</html>