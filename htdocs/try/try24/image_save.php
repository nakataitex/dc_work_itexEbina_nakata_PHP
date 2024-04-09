<!DOCTYPE html>
<html lang='ja'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>TRY24</title>
</head>

<body>
    <?php
        //送信してない場合エラー
        if(!isset($_FILES['upload_image'])):
            echo 'ファイルが送信されてない';
        exit;
        endif;
           
        $save = 'img/' . basename($_FILES['upload_image']['name']);

        //ファイルを保存先フォルダに移動させる
        if(move_uploaded_file($_FILES['upload_image']['tmp_name'],$save)):
            echo 'アップロード成功';
        else:
            echo 'アップロード失敗';
        endif;
    ?>
</body>

</html>