<?php
function getOrderDetails($pdo)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $order_id = $_SESSION["order_id"];
        $sql = "SELECT p.product_name, o.product_qty, o.price, (o.product_qty * o.price) AS total
        FROM ec_order_details_table o
        JOIN ec_product_table p ON o.product_id = p.product_id
        WHERE o.order_id = :oder_id";
        $param = [":order_id"=> $order_id];
        $result = sql_fetch_data($sql, $param);
        if($result){
            $pdo->commit();
        }
    } catch (PDOException $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}