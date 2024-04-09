<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY13</title>
</head>
<body>
    <?php 
        $score = rand(0,100);
        $s = 3;
        print '<p>'.$score.'</p>';
        switch($score){
            case ($score % 3 == 0 && $score % 6 == 0):
                echo "<p>これは3と6の倍数</p>";
                break;
            case ($score > 0):
                echo "<p>これは3の倍数ではない</p>";
                break;
                case ($score % 3 == 0 && $score % 6 !== 0):
                    echo "<p>これは3の倍数で、6の倍数ではない</p>";
                    break;
        };

        $rand1 = rand(0,100);
        $rand2 = rand(0,100);
        $result1 = $rand1 %3;
        $result2 = $rand %3;
        $result3 = $result1 + $result2;
        switch($rand1){
            case ($rand1 > $rand2):
                echo "ランダム1の方が大きい";
                switch($rand1):
                    case 1:
                        echo "2つの数字には1つ3の倍数がある";
                        break;
                    case 2:
                        echo "2つとも3の倍数";
                        break;
                    default:
                        echo "どちらも3の倍数ではない";
                        break;
                break;
            case ($rand1 < $rand2):
                echo "ランダム2の方が大きい";
                switch($rand1):
                    case 1:
                        echo "2つの数字には1つ3の倍数がある";
                        break;
                    case 2:
                        echo "2つとも3の倍数";
                        break;
                    default:
                        echo "どちらも3の倍数ではない";
                        break;
                break;
            default:
                echo "2つは同じ数です";
                    }

        ?>
</body>
</html>