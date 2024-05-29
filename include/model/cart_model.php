<?php
//価格を確認
function getPrice($product_id)
{
    $sql = "SELECT price FROM ec_product_table WHERE product_id = :product_id";
    $param = [
        ":product_id" => $product_id
    ];
    $product = sqlFetchData($sql, $param, true);
    if (empty($product)) {
        throw new Exception("価格が取得出来ませんでした");
    }
    return $product['price'];
}

//在庫数を確認
function getStockQty($product_id)
{
    $sql = "SELECT stock_qty FROM ec_stock_table WHERE product_id = :product_id";
    $param = [
        ":product_id" => $product_id
    ];
    $product = sqlFetchData($sql, $param, true);
    if (empty($product)) {
        throw new Exception("在庫数が取得出来ませんでした");
    }
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
    $result = sqlFetchData($sql, $param);
    if (!$result) {
        throw new Exception("在庫数の更新に失敗しました");
    }
}

//カートからすべての商品を削除する
function allDeleteFromCart()
{
    try {
        $user_id = $_SESSION["user_id"];
        $delete_sql = "DELETE FROM ec_cart_table WHERE user_id = :user_id";
        $param = [
            ":user_id" => $user_id
        ];
        $delete = sqlFetchData($delete_sql, $param);
        return $delete;
    } catch (PDOException $e) {
        throw new Exception('エラー：' . $e->getMessage());
    }
}

//在庫数よりカートの商品数の方が多くないか確認して購入
function order($cart_data, $pdo)
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        //注文id生成
        $user_id = $_SESSION["user_id"];
        $date = currentDate();
        $total_amount = 0;
        $insert_order_sql = "INSERT INTO ec_order_table (user_id, order_date, total_amount, create_date)
        VALUES(:user_id, :order_date, :total_amount, :create_date)";
        $insert_order_param = [
            ":user_id" => $user_id,
            ":order_date" => $date,
            ":total_amount" => $total_amount,
            ":create_date" => $date
        ];
        sqlFetchData($insert_order_sql, $insert_order_param);
        $order_id = $pdo->lastInsertId();
        $total_amount = insertOrderDetail($cart_data, $pdo, $date);
        //注文詳細を作成
        $update_order_sql = "UPDATE ec_order_table 
        SET total_amount = :total_amount, update_date = :update_date
        WHERE order_id = :order_id";
        $update_order_param = [
            "total_amount" => $total_amount,
            ":update_date" => $date,
            ":order_id" => $order_id
        ];
        $buy = sqlFetchData($update_order_sql, $update_order_param);
        if ($buy) {
            allDeleteFromCart();
            $pdo->commit();
            return $order_id;
        } else {
            $pdo->rollBack();
            throw new Exception("購入の際にエラーが発生しました");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception($e->getMessage());
    }
}

//注文詳細を挿入
function insertOrderDetail($cart_data, $pdo, $date)
{
    $order_id = $pdo->lastInsertId();
    $date = currentDate();
    //カート内の商品情報の取得
    foreach ($cart_data as $product) {
        $product_id = $product["product_id"];
        $cart_qty = (int)$product["product_qty"];
        $price = getPrice($product_id);
        $stock_qty = (int)getStockQty($product_id);
        //在庫が不足していないか確認
        if ($stock_qty < $cart_qty) {
            throw new Exception('商品名:' . $product["product_name"] . 'の在庫数が足りない為購入出来ません');
        }
        $insert_order_detail_sql =
            "INSERT INTO ec_order_details_table (order_id, product_id, product_qty, price, create_date) 
                VALUES (:order_id, :product_id, :product_qty, :price, :create_date)";
        $insert_order_detail_param = [
            ":order_id" => $order_id,
            ":product_id" => $product_id,
            ":product_qty" => $cart_qty,
            ":price" => $price,
            ":create_date" => $date
        ];
        $order_detail = sqlFetchData($insert_order_detail_sql, $insert_order_detail_param);
        if (!$order_detail) {
            throw new Exception("注文詳細の作成に失敗しました");
        }
        //在庫数を更新
        updateStock($product_id, $cart_qty);
        //総額の計算
        $total_amount += $price * $cart_qty;
    }
    return $total_amount;
}

//カートから削除する
function deleteFromCart($pdo)
{
    try {
        $pdo->beginTransaction();
        $product_id = $_POST["product_id"];
        $user_id = $_SESSION["user_id"];
        $delete_sql = "DELETE FROM ec_cart_table WHERE product_id = :product_id AND user_id = :user_id";
        $param = [
            ":product_id" => $product_id,
            ":user_id" => $user_id
        ];
        $result = sqlFetchData($delete_sql, $param);
        if (isset($result)) {
            $pdo->commit();
            $message = "カートから商品を削除しました";
            return $message;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('エラー：' . $e->getMessage());
    }
}

//数量のバリデーション
function cartIntValidation()
{
    if (isset($_POST["stock_qty"])) {
        if ($_POST["stock_qty"] < 1 || !is_numeric($_POST["stock_qty"])) {
            throw new Exception("在庫数は1以上の整数を指定してください");
        }
    }
}

//カート内の商品の数量を変更 
function updateCartQty()
{
    $product_qty = (int) $_POST["product_qty"] ?? 0;
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
        return sqlFetchData($sql, $param, true);
    }
}

//カートの中の商品数を変更する
function updateQtyFromCart($pdo)
{
    try {
        $pdo->beginTransaction();
        cartIntValidation();
        $result = updateCartQty();
        if ($result) {
            $pdo->commit();
            $message = "商品数を変更しました";
            return $message;
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('エラー：' . $e->getMessage());
    }
}

//カートの中を取得する
function getCart()
{
    $sql = "SELECT p.product_id,i.image_name,p.product_name,p.price,c.product_qty,s.stock_qty
    FROM ec_cart_table c INNER JOIN ec_product_table p
    ON c.product_id = p.product_id
    JOIN ec_image_table i
    ON p.product_id = i.product_id
    JOIN ec_stock_table s
    ON p.product_id = s.product_id 
    WHERE c.user_id = :user_id;";
    $user_id = $_SESSION["user_id"];
    $param = [
        ":user_id" => $user_id
    ];
    $result = sqlFetchData($sql, $param);
    if ($result !== false) {
        return $result;
    } else {
        throw new Exception("カートに何も入っていません");
    }
}

//小計金額を計算する
function getTotalAmount($cart_data)
{
    $total_amount = 0;
    foreach ($cart_data as $product) {
        if (isset($product["price"])) {
            $price = $product["price"];
            $qty = $product["product_qty"];
            $total_amount += $price * $qty;
        }
    }
    return $total_amount;
}