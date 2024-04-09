<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY15</title>
</head><p></p>
<body>
    <?php
        // iが1から始まり、10以下の間繰り返し処理を行う
        for ($i = 1; $i <= 100; $i++):
        switch ($i):
            case ($i % 3 == 0 && $i % 4 !== 0):
                echo "<p>Fizz</p>";
                break;
                case ($i % 3 !== 0 && $i % 4 == 0):
                    echo "<p>Buzz</p>";
                    break;
                case ($i % 3 == 0 && $i % 4 == 0):
                        echo "<p>Fizz Buzz</p>";
                    break;
                default:
                echo '<p>'.$i.'</p>';
                endswitch;
            endfor;
    ?>
</body>
</html>