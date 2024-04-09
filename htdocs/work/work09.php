<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset='UTF-8'>
    <title>work8</title>
</head>
<body>
    <?php 
    $s1 = rand(0,100);
    $s2 = rand(0,100);

    print '<p>score1は'.$s1.'</p>';
    print '<p>score2は'.$s2.'</p>';
    $a = $s1 % 3;
    $b = $s1 % 3;
    $c = 0;
    $result = 0;
    switch($c = $a + $b):
        case 0:
            $result = '<p>2つの数字には3の倍数はない</p>';
            break;
        case 1:
            $result = '<p>この数字には3の倍数が1つある</p>';
            break;
        default:
            $result = '<p>この数字には3の倍数が2つある</p>';
        endswitch;

    switch($s1):
        case ($s1 > $s2):
            echo '<p>score1の方が大きい。</p>';
            echo '<p>'.$result.'</p>';
            break;
            case ($s1 < $s2):
                echo '<p>score2の方が大きい。</p>';
                echo '<p>'.$result.'</p>';
                break;
                case ($s1 == $s2):
                    echo '<p>２つは同じ数</p>';
                    echo '<p>'.$result.'</p>';
                endswitch;
    ?>
</body>
</html>