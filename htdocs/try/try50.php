<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try50</title>
</head>
<body>
<?php 
        //グローバル変数
        $global_variable = "グローバル変数";//関数外で宣言

        function set_local_variable(){
            $local_variable = "ローカル変数";//関数内で宣言
            echo "<p>関数内のローカル変数：".$local_variable."</p>";
            echo "<p>関数内のグローバル変数：".$global_variable."</p>";
        }

        echo set_local_variable();
        echo "<p>関数外のグローバル変：".$global_variable."</p>";
        echo "<p>関数外のローカル変数：".$local_variable."</p>";
    ?>
</body>
</html>