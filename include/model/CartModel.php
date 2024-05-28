<?php
//価格を確認
function getPrice($product_id)
{
    $sql = "SELECT price FROM ec_product_table WHERE product_id = :product_id";
    $param = [
        ":product_id" => $product_id
    ];
    $product = sql_fetch_data($sql, $param, true);
    return $product['price'];
}

//在庫数を確認
function getStockQty($product_id)
{
    $sql = "SELECT stock_qty FROM ec_stock_table WHERE product_id = :product_id";
    $param = [
        ":product_id" => $product_id
    ];
    $product = sql_fetch_data($sql, $param, true);
    return $product['stock_qty'];
}

//購入に合わせて在庫数を更新
function updateStock($product_id, $cart_qty)
{
    $sql = "UPDATE ec_stock_table SET stock_qty = stock_qty - :cart_qty WHERE product_id = :product_id";
    $param = [
        ":cart_qty" => $cart_qty,
        ":product_id" => $product_id
    ];
    sql_fetch_data($sql, $param);
}

//カートから商品を削除
function allDeleteFromCart()
{
    try {
        $user_id = $_SESSION["user_id"];
        $delete_sql = "DELETE FROM ec_cart_table WHERE user_id = :user_id";
        $param = [
            ":user_id" => $user_id
        ];
        $delete = sql_fetch_data($delete_sql, $param);
        return $delete;
    } catch (PDOException $e) {
        throw $e;
    }
}

//在庫数よりカートの商品数の方が多くないか確認して購入、購入したら
function order($cart_data, $error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $user_id = $_SESSION["user_id"];
        $date = currentDate();
        $total_amount = 0;
        //注文id生成
        $insert_order_sql = "INSERT INTO ec_order_table (user_id, order_date, total_amount, create_date)VALUES(:user_id, :order_date, :total_amount, :create_date)";
        $insert_order_param = [
            ":user_id" => $user_id,
            ":order_date" => $date,
            ":total_amount" => $total_amount,
            ":create_date" => $date
        ];
        sql_fetch_data($insert_order_sql, $insert_order_param);
        $order_id = $pdo->lastInsertId();
        //在庫と価格の確認
        foreach ($cart_data as $product) {
            $product_id = $product["product_id"];
            $cart_qty = $product["product_qty"];
            $price = getPrice($product_id);
            if(empty($price)) {
                $error_message[] ="価格が取得できませんでした";
                throw new Exception($error_message);
            }
            $stock_qty = getStockQty($product_id);
            if ($stock_qty < $cart_qty) {
                $error_message[] = '在庫が足りません。商品名:' . $product["product_name"];
                throw new Exception($error_message);
            }
            $insert_order_detail_sql = "INSERT INTO ec_order_details_table (order_id, product_id, product_qty, price, create_date) VALUES (:order_id, :product_id, :product_qty, :price, :create_date)";
            $insert_order_detail_param = [
                ":order_id" => $order_id,
                ":product_id" => $product_id,
                ":product_qty" => $cart_qty,
                ":price" => $price,
                ":create_date" => $date
            ];
            $order_detail =  sql_fetch_data($insert_order_detail_sql, $insert_order_detail_param);
            if(!$order_detail){
                $error_message[] = "注文詳細の作成に失敗しました";
                throw new Exception($error_message);
            }
            //総額の計算
            $total_amount += $price * $cart_qty;
            //在庫数を更新
            updateStock($product_id, $cart_qty);
        }
        //注文詳細を作成
        $update_order_sql = "UPDATE ec_order_table SET total_amount = :total_amount, update_date = :update_date WHERE order_id = :order_id";
        $update_order_param = [
            "total_amount" => $total_amount,
            ":update_date" => $date,
            ":order_id" => $order_id
        ];
        $buy = sql_fetch_data($update_order_sql, $update_order_param);
        if ($buy) {
            allDeleteFromCart();
            $pdo->commit();
            return $order_id;
        } else {
            $pdo->rollBack();
            $error_message[] = "購入の際にデータベースエラーが発生しました";
            throw new Exception($error_message);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $error_message[] = 'エラーが発生しました：' . $e->getMessage();
        throw new Exception($error_message);
    }
}
//カートから削除する
function deleteFromCart($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $product_id = $_POST["product_id"];
        $user_id = $_SESSION["user_id"];
        $delete_sql = "DELETE FROM ec_cart_table WHERE product_id = :product_id AND user_id = :user_id";
        $param = [
            ":product_id" => $product_id,
            ":user_id" => $user_id
        ];
        $delete = sql_fetch_data($delete_sql, $param);
        if (isset($delete) && empty($error_message)) {
            $pdo->commit();
        }
    } catch (Exception $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}

//カートの中の商品数を変更する
function updateQtyFromCart($error_message)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $result = updateCartQty();
        if (!$error_message && $result) {
            $pdo->commit();
        }
    } catch (Exception $e) {
        $error_message[] = 'データベースエラー：' . $e->getMessage();
        $pdo->rollBack();
        return $error_message;
    }
}

//カートの中を取得する
function getCart()
{
    $sql = "SELECT
            p.product_id,i.image_name,p.product_name,p.price,c.product_qty
            FROM ec_cart_table c
            INNER JOIN ec_product_table p
            ON c.product_id = p.product_id 
            JOIN ec_image_table i
            ON p.product_id = i.product_id
            WHERE c.user_id = :user_id;";
    $user_id = $_SESSION["user_id"];
    $param = [
        ":user_id" => $user_id
    ];
    return sql_fetch_data($sql, $param);
}

//カート内の商品の数量を変更 
function updateCartQty()
{
    try {
        $product_qty = (int) $_POST["product_qty"] ?? 0;
        var_dump($product_qty);
        if ($product_qty > 0) {
            $sql = "UPDATE ec_cart_table SET product_qty = :product_qty, update_date = :update_date WHERE user_id = :user_id AND product_id = :product_id";
            $product_qty = $_POST["product_qty"];
            $update_date = currentDate();
            $user_id = $_SESSION["user_id"];
            $product_id = $_POST["product_id"];
            $param = [
                ":product_qty" => $product_qty,
                ":update_date" => $update_date,
                ":user_id" => $user_id,
                ":product_id" => $product_id
            ];
            return sql_fetch_data($sql, $param, true);
        }
    } catch (Exception $e) {
        throw $e;
    }
}