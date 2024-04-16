<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像投稿ページ</title>
</head>
<body>
    <form action="image_view.php" method = "post" enctype="multipart/form-data">
        タイトル：<input type="text" name="title"><br>
        画像：<input type="file" name="img"><br>
        <input type="submit" value="投稿">
    </form>
<?php
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_error) :
        echo "DB接続エラー$db->connect_error";
        exit();
    else:
        $db->set_charset("utf8");
        echo "DB接続完了";
    endif;
    ?>

    
</body>
</html>