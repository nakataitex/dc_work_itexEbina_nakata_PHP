<?php

//カート内に追加しようとした商品のカート内の数を確認
function checkCartQty()
{
    $user_id = $_SESSION["user_id"];
    $product_id = $_POST["product_id"];
    $check_cart_sql = 'SELECT product_qty, product_id, user_id FROM ec_cart_table WHERE user_id = :user_id AND product_id = :product_id';
    $sql_param = [
        ":user_id" => $user_id,
        ":product_id" => $product_id
    ];
    $cart_qty = sql_fetch_data($check_cart_sql, $sql_param, true);
    return $cart_qty;
}

//カートに追加
function addCart($error_message)
{
    try {
        $user_id = $_SESSION["user_id"];
        $product_id = $_POST["product_id"];
        if (!isset($_POST["product_qty"]) || (int) $_POST["product_qty"] <= 0) {
            $error_message[] = "1以上の整数を入力してください";
            return $error_message;
        }
        $add_qty = (int) $_POST["product_qty"];
        $cart_qty_check = checkCartQty();
        $cart_qty = $cart_qty_check ? $cart_qty_check["product_qty"] : 0;
        $product_qty = $cart_qty + $add_qty;
        $date = currentDate();
        if ($add_qty > 0) {
            if ($cart_qty === 0) {
                $sql = "INSERT INTO ec_cart_table (user_id, product_id,product_qty, create_date)VALUES (:user_id,:product_id, :product_qty, :create_date)";
                $param = [
                    ":user_id" => $user_id,
                    ":product_id" => $product_id,
                    ":product_qty" => $product_qty,
                    ":create_date" => $date
                ];
            } else {
                $sql = "UPDATE ec_cart_table SET product_qty = :product_qty, update_date = :update_date WHERE user_id = :user_id AND product_id = :product_id";
                $param = [
                    ":product_qty" => $product_qty,
                    ":update_date" => $date,
                    ":user_id" => $user_id,
                    ":product_id" => $product_id
                ];
            }
            sql_fetch_data($sql, $param, true);
        } else {
            $error_message[] = "1以上の整数を指定してください";
            return $error_message;
        }
    } catch (Exception $e) {
        throw $e;
    }
}


//商品リストを表示
function getCatalog()
{
    $sql = "SELECT p.product_id,p.product_name, p.price,i.image_name,s.stock_qty FROM ec_stock_table s
    INNER JOIN ec_image_table i
    ON s.product_id = i.product_id 
    JOIN ec_product_table p
    ON i.product_id = p.product_id WHERE p.public_flg = 1";
    return sql_fetch_data($sql);
}