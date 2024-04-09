<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY07</title>
</head>
<body>
    <?php 
        $num = 10; 
        $str = '10';

        print var_dump($num == $str);	// true
        print var_dump($num === $str);	// false

        $num = 9;
        print var_dump($num == $str); //9と10は違うのでfalse
        $str = $num;
        print var_dump($num === $str);//numとstrは等しいのでtrue
        
    ?>
</body>
</html>