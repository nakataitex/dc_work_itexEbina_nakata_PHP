<?php
$dsn = 'mysql:host=localhost;dbname=xb513874_u338x';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>work37ホーム</title>
</head>

<body>
    <?php
    //接続
    try {
        $db = new PDO($dsn, $login_user, $password);
        echo "DB接続に成功しました<br>";
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
    $user_name = $_POST['user_name'];//入力したID
    $user_password = $_POST['pass'];//入力したパス
    
    //ハッシュ化
  //$hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    //SELECT文の実行(ネームからIDを追跡→あってるならそのIDのパスワードが合ってるか確認)
    $idcheck = 'SELECT 
                user_name,password 
            FROM 
                user_table
            WHERE 
                user_name = :user_name AND password = :pass;
        ';
    $stmt = $db->prepare($idcheck);
    $stmt->bindparam(':user_name', $user_name);
    $stmt->bindparam(':pass', $user_password);
    //SQL実行
    $stmt->execute();

    //認証結果取得
    $result = $stmt->fetch(PDO::FETCH_NUM);

    if ($result):
        echo 'ようこそ'.$user_name.'さん<br>';
    else://ない場合
        echo "IDが存在しないかパスが違います<br>";
    endif;

//cookie


    //Cookieの保存期間
define('EXPIRATION_PERIOD', 30);
$cookie_expiration = time() + EXPIRATION_PERIOD * 60 * 24 * 365;

//POSTされたフォームの値を変数に格納
if(isset($_POST['cookie_confirmation']) === TRUE) {
    $cookie_confirmation = $_POST['cookie_confirmation'];
}else{
    $cookie_confirmation = '';
}
if(isset($_POST['user_name']) === TRUE) {
    $save_user_name = $_POST['user_name'];
}    else{
    $save_user_name = '';
}

//チェックされてればcookie保存
if ($cookie_confirmation === 'checked') {
    setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
    setcookie('user_name', $save_user_name, $cookie_expiration);
} else {
    // チェックされていない場合はCookieを削除する
    setcookie('cookie_confirmation', '', time() - 30);
    setcookie('user_name', '', time() - 30);
} 

    ?>
</body>

</html>