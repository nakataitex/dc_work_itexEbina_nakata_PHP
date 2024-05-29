<?php
//注文詳細情報を取得
function getOrderDetails($pdo)
{
    $order_id = $_SESSION["order_id"];
    $sql = "SELECT p.product_name, od.product_qty, od.price,i.image_name
        FROM ec_order_details_table od
        INNER JOIN ec_product_table p ON od.product_id = p.product_id 
                INNER JOIN ec_image_table i ON p.product_id = i.product_id WHERE od.order_id = :order_id";
    $param = [":order_id" => $order_id];
    $result = sqlFetchData($sql, $param);
    if ($result) {
        return $result;
    }
}

//小計金額を取得
function getTotalAmountSql()
{
    try {
        $order_id = $_SESSION["order_id"];
        $sql = "SELECT total_amount
        FROM ec_order_table
        WHERE order_id = :order_id";
        $param = [":order_id" => $order_id];
        $result = sqlFetchData($sql, $param, true);
        return $result;
    } catch (Exception $e) {
        throw new Exception('エラー：' . $e->getMessage());
    }
}

//注文IDがない状態でアクセスした場合商品一覧ページに遷移
function sessionOrderIdCheck()
{
        if (empty($_SESSION["order_id"]) || !isset($_SESSION["order_id"])) {
            throw new Exception("セッションから注文IDを取得出来ませんでした");
        }
}
