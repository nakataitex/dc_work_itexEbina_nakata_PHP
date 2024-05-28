<?php
function getOrderDetails($pdo)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $order_id = $_SESSION["order_id"];
        $sql = "SELECT p.product_name, od.product_qty, od.price,i.image_name
        FROM ec_order_details_table od
        INNER JOIN ec_product_table p ON od.product_id = p.product_id 
                INNER JOIN ec_image_table i ON p.product_id = i.product_id WHERE od.order_id = :order_id";
        $param = [":order_id" => $order_id];
        $result = sql_fetch_data($sql, $param);
        if ($result) {
            $pdo->commit();
            return $result;
        }
    } catch (PDOException $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}

//小計金額を取得
function getTotalAmount()
{
    try {
        $order_id = $_SESSION["order_id"];
        $sql = "SELECT total_amount
        FROM ec_order_table
        WHERE order_id = :order_id";
        $param = [":order_id" => $order_id];
        $result = sql_fetch_data($sql, $param, true);
        return $result;
    } catch (PDOException $error_message) {
        throw $error_message;
    }
}

//注文IDがない状態でアクセスした場合商品一覧ページに遷移
function sessionOrderIdCheck($error_message)
{
    if (empty($order_data)) {
        $error_message[] = "セッションから注文IDを取得出来ませんでした";
        return $error_message;
    }
}
