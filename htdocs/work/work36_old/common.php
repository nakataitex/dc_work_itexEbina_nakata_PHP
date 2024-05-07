<?php
//画像の公開切り替えのファンクション
function togglePublicStatus($imageID)
{
    global $db, $date, $notifications, $error_msg;
    $db->begin_transaction();
    $public_change = ("UPDATE image_sharing SET public_flg = 1 - public_flg , update_date = ? WHERE image_id = ?");
    $stmt = $db->prepare($public_change);
    $stmt->bind_param("st", $date, $imageID);
    $stmt->execute();
    echo $stmt->affected_rows . "件の切り替えに成功しました";

    //実行
    if ($stmt->execute()) {
        $row = $stmt->affected_rows;
        //クエリが実行出来たら
        $notifications[] = '<p class="message">' . $row . '件の切り替えに成功<br>画像ID:' . $imageID . '</p>';
        $db->commit();
    } else {
        $error_msg[] = 'UPDATE実行エラー[実行SQL]' . $public_change;
        $notifications[] = '<p class= "message">エラーが発生した為取り消し</p><br>';
        $db->rollBack();
    }
}
