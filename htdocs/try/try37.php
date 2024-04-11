<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>try37</title>
</head>
<body><?php
//データベースに接続
    $db = new mysqli('localhost', 'xb513874_fpu2g', "mj3mt8vtwv", "xb513874_u338x");
    if($db ->connect_error):
        echo $db->connect_error;
        exit();
    else:
        print ("データベースへの接続成功");
        endif;
        $db->close();//接続終了
?>
</body>
</html>