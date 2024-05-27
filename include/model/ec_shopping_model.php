<?php
//カート内に追加しようとした商品の数を確認
function check_cart($add_cart_param)
{
    $check_cart_sql = 'SELECT product_qty, product_id, user_id FROM ec_cart_table WHERE user_id = :user_id AND product_id = :product_id';
    $sql_param = [
        ":user_id" => $add_cart_param["user_id"],
        ":product_id" => $add_cart_param["product_id"]
    ];
    $data = sql_fetch_data($check_cart_sql, $sql_param);

    return $data;
}

//在庫数を確認
function stock_qty_check($product_id)
{
    $stock_qty_sql = 'SELECT stock_qty FROM ec_stock_table WHERE product_id = :product_id';
    $stock_qty_param = [
        ":product_id" => $product_id
    ];
    return sql_fetch_data($stock_qty_sql, $stock_qty_param);
}

//カートに追加
function add_cart($cart_qty, $add_cart_param)
{
    $date = current_date();
    if ($cart_qty === 0) {//カートに入ってなければINSERT
        $add_cart_sql =
            'INSERT INTO  
                    ec_cart_table (user_id,product_id,product_qty,create_date)VALUES(:user_id,:product_id,:product_qty,:create_date)';
        $add_cart_param[":create_date"] = $date;
        print_r($add_cart_param);
    } else {//カートに入っていたらUPDATE
        $add_cart_sql =
            'UPDATE ec_cart_table SET product_qty = :product_qty, update_date = :update_date WHERE user_id = :user_id AND product_id = :product_id';
        $add_cart_param[":update_date"] = $date;
    }
    return sql_fetch_data($add_cart_sql, $add_cart_param);
}

//商品をカートに追加
function insert_cart($pdo, $form)
{
    try {
        $pdo->beginTransaction();
        $sql = "INSERT INTO ec_cart_table (user_id, product_id, product_qty, create_date) VALUES (:user_id, :product_id, :product_qty, :create_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":user_id", $form["user_id"]);
        $stmt->bindValue(":product_id", $form["product_id"]);
        $stmt->bindValue(":product_qty", $form["product_qty"]);
        $stmt->bindValue(":create_date", current_date());
        $success = $stmt->execute();
        if ($success) {
            $pdo->commit();
        }
        return $success;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $pdo->rollBack();
        exit();
    }
}


//商品リストを表示
function get_product_list($pdo)
{
    $sql = "SELECT p.product_id,p.product_name, p.price,i.image_name,s.stock_qty FROM ec_stock_table s
    INNER JOIN ec_image_table i
    ON s.product_id = i.product_id 
    JOIN ec_product_table p
    ON i.product_id = p.product_id";
    return get_sql_result($pdo, $sql);
}

//該当ユーザーIDのカート内をリスト化
function get_cart_list($user_id)
{
    $sql = "SELECT p.product_id,p.product_name, p.price,i.image_name,c.product_qty 
    FROM ec_cart_table c 
    INNER JOIN ec_product_table p ON c.product_id = p.product_id
    INNER JOIN ec_image_table i ON p.product_id = i.product_id 
    WHERE user_id = :user_id";
    $param = [
        ":user_id" => $user_id
    ];
    return sql_fetch_data($sql, $param);
}