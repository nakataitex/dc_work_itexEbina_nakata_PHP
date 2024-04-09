<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TRY23</title>
</head>
<body>
    <form method="post">
<?php
    $fp = fopen("try23.txt", "w");//変数をtry22.txtを書き換える変数に。

    fwrite($fp , "この内容をファイルへ書き込む");
    fclose($fp);//ファイル操作を終わる
        ?>
</body>
</html>