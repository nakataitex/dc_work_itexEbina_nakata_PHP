<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY17</title>
</head>
<body>
    <?php 
    $s = 1;
    while($s <= 100):
        switch($s):
            case ($s % 3 == 0):
                echo '<p>Fizz</p>';
                break;
            case ($s % 4 == 0):
                echo '<p>Buzz</p>';
                break;
            default:
                echo '<p>'.$s.'</p>';
            endswitch;
        $s++;
        endwhile;
    ?>
</body>
</html>