<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try49</title>
</head>
<body>
    <?php
        //引数なし・返り値なしの関数実行
        output_function();
        //引数・返り値なしの関数実行
        output_function_num(10);
        //引数あり戻り値ありの関数を実行し、戻り値の出力
        $function_num = make_function_num(10);
        echo $function_num;
        
        function output_function(){
            echo "<p>引数：なし、返り値：なしの関数</p>";
        }

        function output_function_num($num){
            echo "<p>引数：".$num."返り値：なしの関数</p>";
        }
        //引数：あり、返り値：ありの関数
        function make_function_num ($num){
            $str = "<p>引数".$num."返り値:ありの関数</p>";
            return $str;
        }

    ?>
</body>
</html>