<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head>
<body>
    <?php
        // iが1から始まり、10以下の間繰り返し処理を行う
        for ($i = 1; $i <= 100; $i++){
        switch ($i):
            case ($i % 3 == 0 && $i % 4 !== 0):
                echo "Fizz";
                break;
                case ($i % 3 !== 0 && $i % 4 == 0):
                    echo "Buzz";
                    break;
                case ($i % 3 == 0 && $i % 4 == 0):
                        echo "Fizz Buzz";
                    break;
                default:
                echo $i;
                endswitch;
        } 
    ?>
</body>
</html>