<?php

//画像の公開切り替え
if (isset($_POST["image_id"]))://公開/非公開を押したら
    $get_image_id = $_POST['image_id'];
    echo 'ID:'.$get_image_id.'のボタンを押した<br>';
    $db->begin_transaction();//トランザクション開始
    //公開切り替え
    $public_change = 
    'UPDATE
        image_sharing
    SET
        public_flg = 1 - public_flg
    WHERE
    image_id = '.$_POST["image_id"].';';
    //実行
    if ($public_change_result = $db->query($insert_query)):
        $row = $db->affected_rows;
        //クエリが実行出来るか
        echo "クエリが実行できた<br>";
    else:
        $error_msg[] = 'INSERT実行エラー[実行SQL]' . $insert_query;
    endif;

    if (count($error_msg) > 0)://エラー時の処理
        echo "エラーが発生した為作業を取り消します。<br>";
        $db->rollback();
    else://成功時の処理
        echo "$row 件の切り替えに成功しました。<br>切り替えた画像のID: $get_image_id";
        $db->commit();

        //var_dump($error_msg);
    endif;
endif;