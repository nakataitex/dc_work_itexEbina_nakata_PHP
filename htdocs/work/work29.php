<?php
$host = 'localhost';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';
$database = 'xb513874_u338x';
$error_msg = [];
$product_name;
$price;
$price_val;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>work29</title>
</head>

<body>
    <?php
    //SQLにログイン
    $db = new mysqli($host, $login_user, $password, $database);
    if ($db->connect_errno):
        echo $db->connect_error;
        exit();
    else:
        echo "接続成功<br>";
        $db->set_charset("utf8");//文字コード指定
    endif;
    if ($_SERVER["REQUEST_METHOD"] == "POST")://ポストでインサートを送信したら
        if (isset($_POST['insert']))://インサートが押されたら
            $db->begin_transaction();//トランザクション開始
            //INSERT文
            $insert_query = "INSERT INTO product(
            product_id,
            product_code,
            product_name,
            price,
            category_id 
            )
            VALUES(
                21,
                1021,
                'エシャロット',
                200,
                1
            )";

            //実行
            if ($result = $db->query($insert_query)):
                $row = $db->affected_rows;
            else:
                $error_msg[] = "INSERT実行エラー[実行SQL]" . $insert_query;
            endif;

            if (count($error_msg) > 0)://エラーメッセージがあるなら
                echo "挿入失敗<br>";//ログ
                $db->rollback();//ロールバック。全取り消し
            else:
                echo "$row の挿入に成功しました。<br>";
                $db->commit();//コミット。反映させる
            endif;
            //エラー確認
            //var_dump($error_msg);
    
            //DELETEが押されたら
        elseif (isset($_POST["delete"])):
            $db->begin_transaction();//トランザクション開始
            //DELETEクエリ
            $delete_query = "
                DELETE 
                FROM 
                product 
                WHERE 
                product_id = 21;
            ";
            //削除実行
            if ($result = $db->query($delete_query)):
                $row = $db->affected_rows;
            else:
                $error_msg[] = "DELETE実行エラー[実行SQL]" . $delete_query;
            endif;


            if (count($error_msg) > 0)://エラーがあれば
                echo "削除失敗<br>";
                $db->rollback();//ロールバック。全取り消し
            else://なければ
                echo "$row の削除に成功しました。";
                $db->commit();
            endif;
            //エラー確認
            //var_dump($error_msg);
        endif;
    endif;



    ?>
    <form method="POST">
        <input type="submit" name="insert" value="挿入">
        <input type="submit" name="delete" value="削除">
    </form>
</body>

</html>