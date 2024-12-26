<?php

//カート内に追加しようとした商品のカート内の数を確認
function checkCartQty()
{
    $user_id = $_SESSION["user_id"];
    $product_id = $_POST["product_id"];
    $check_cart_sql = 'SELECT product_qty, product_id, user_id FROM ec_cart_table_test WHERE user_id = :user_id AND product_id = :product_id';
    $sql_param = [
        ":user_id" => $user_id,
        ":product_id" => $product_id
    ];
    $cart_qty = sqlFetchData($check_cart_sql, $sql_param, true);
    return $cart_qty;
}

//カートに追加
function addCart()
{
    try {
        $pdo = getConnection();
        $pdo->beginTransaction();
        $user_id = $_SESSION["user_id"];
        $product_id = $_POST["product_id"];
        if (!isset($_POST["product_qty"]) || (int) $_POST["product_qty"] <= 0) {
            throw new Exception("1以上の整数を入力してください");
        }
        $add_qty = (int) $_POST["product_qty"];
        $cart_qty_check = checkCartQty();
        $cart_qty = $cart_qty_check ? $cart_qty_check["product_qty"] : 0;
        $product_qty = $cart_qty + $add_qty;
        $date = currentDate();
        if ($add_qty > 0) {
            if ($cart_qty === 0) {
                $sql = "INSERT INTO ec_cart_table_test (user_id, product_id,product_qty, create_date)VALUES (:user_id,:product_id, :product_qty, :create_date)";
                $param = [
                    ":user_id" => $user_id,
                    ":product_id" => $product_id,
                    ":product_qty" => $product_qty,
                    ":create_date" => $date
                ];
            } else {
                $sql = "UPDATE ec_cart_table_test SET product_qty = :product_qty, update_date = :update_date WHERE user_id = :user_id AND product_id = :product_id";
                $param = [
                    ":product_qty" => $product_qty,
                    ":update_date" => $date,
                    ":user_id" => $user_id,
                    ":product_id" => $product_id
                ];
            }
            sqlFetchData($sql, $param, true);
            $pdo->commit();
            $message = "カートに追加しました";
            return $message;
        } else {
            $pdo->rollBack();
            throw new Exception("1以上の整数を指定してください");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw new Exception('データベースエラー：' . $e->getMessage());
    }
}

//商品リストを表示
function getCatalog()
{
    $sql = "SELECT p.product_id,p.product_name, p.price,i.image_name,s.stock_qty
    FROM ec_stock_table_test s
    INNER JOIN ec_image_table_test i
    ON s.product_id = i.product_id 
    JOIN ec_product_table_test p
    ON i.product_id = p.product_id
    WHERE p.public_flg = 1";
    return sqlFetchData($sql);
}
;

//商品リストを表示（テスト）
function getCatalogVariable($pagination_limit = DEFAULT_PAGINATION_LIMIT, $page_num = 0)
{
    if (isset($_GET["pagination_limit"])) {
        $pagination_limit = $_GET["pagination_limit"];
    }

    if (isset($_GET["page_num"])) {
        $page_num = $_GET["page_num"];
    }

    $sql = 'SELECT p.product_id, p.product_name, p.price,i.image_name,s.stock_qty 
        FROM ec_stock_table_test s 
        INNER JOIN ec_image_table_test i 
        ON s.product_id = i.product_id 
        JOIN ec_product_table_test p 
        ON i.product_id = p.product_id 
        WHERE p.public_flg = 1 
        LIMIT ' . $pagination_limit . ' 
        OFFSET ' . $page_num;
    return sqlFetchData($sql);
}