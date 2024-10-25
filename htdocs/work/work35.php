<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>twork35</title>
</head>

<body>
    <?php
    $rand = rand(1, 100);
    function_i($rand);
    function function_i($a)
    {
        if ($a % 2 == 0):
            echo $a . 'は偶数なので10倍して' . $a * 10;

        else:
            echo $a . 'は奇数なので100倍して' . $a * 100;
        endif;

    }


    ?>
</body>

</html>