<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>uponly</title>
</head>

<body>
    <form method="post"  enctype="multipart/form-data">
        <p><input type="file" name="upload_image"></p>
        <p><input type="submit" value="送信"></p>
    </form>
    <?php
        if(!isset($_FILES['upload_image'])){
            echo 'ファイルが送信されていません。';
        }

        $save = 'img/' . basename($_FILES['upload_image']['name']);

        //ファイルを保存先ディレクトリに移動させる
        if(move_uploaded_file($_FILES['upload_image']['tmp_name'], $save)){
            echo 'アップロード成功しました。';
        }else{
            echo 'アップロード失敗しました。';
        }
    ?>
</body>

</html>