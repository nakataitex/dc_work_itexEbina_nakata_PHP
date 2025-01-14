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


function sqlfetchDataTest($sql, $params = [], $singleRow = false)
{
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $param) {
            $value = $param['value'];
            $type = $param['type'] ?? PDO::PARAM_STR; // 型が指定されていない場合は文字列型

            $stmt->bindValue($key, $value, $type); // 型を指定
        }

        $result = $stmt->execute();
        if ($result) {
            if (stripos($sql, 'SELECT') === 0) {
                if ($singleRow) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            } else {
                return $stmt->rowCount();
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {

        error_log("SQL Error: " . $sql . "\n" . $e->getMessage());
        throw new Exception("データベースエラー: " . $e->getMessage());
    }
}

//商品リストを表示（分割）
function getCatalogVariable($pdo, $product_public_flg)
{

    $pagination_limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : DEFAULT_PAGINATION_LIMIT;
    $page_num = isset($_GET["page_num"]) ? intval($_GET["page_num"]) : 0;

    //2ページ目以降ページ毎に表示内容を変更
    $currently_displayed_item = $page_num * $pagination_limit;

    //SQL
    try {
        $sql = 'SELECT p.product_id, p.product_name, p.price,i.image_name,s.stock_qty 
        FROM ec_stock_table_test s 
        INNER JOIN ec_image_table_test i 
        ON s.product_id = i.product_id 
        JOIN ec_product_table_test p 
        ON i.product_id = p.product_id 
        WHERE p.public_flg = :public_flg 
        LIMIT :limit
        OFFSET :offset';
        $params = [
            ":public_flg" => ['value' => $product_public_flg, 'type' => PDO::PARAM_INT],
            ":limit" => ['value' => $pagination_limit, 'type' => PDO::PARAM_INT],
            ":offset" => [
                'value' => $currently_displayed_item,
                'type' => PDO::PARAM_INT
            ]
        ];
        $result = sqlfetchDataTest($sql, $params);
        print_r($result);
        if ($result) {
            return $result;
        }
    } catch (PDOException $e) {
        throw new Exception("データベースエラー:商品の取得に失敗しました");
    }
}




function getOrderDetails($pdo)
{
    $order_id = $_SESSION["order_id"];
    $sql = "SELECT p.product_name, od.product_qty, od.price,i.image_name
        FROM ec_order_details_table_test od
        INNER JOIN ec_product_table_test p ON od.product_id = p.product_id 
                INNER JOIN ec_image_table_test i ON p.product_id = i.product_id WHERE od.order_id = :order_id";
    $param = [":order_id" => $order_id];
    $result = sqlFetchData($sql, $param);
    if ($result) {
        return $result;
    }
}

//現在のページを取得
function get_page_num()
{
    if (!isset($_GET["page_num"])) {
        //設定されてない場合は1ページ目にする。
        $page_num = 0;
        return $page_num;
    } else {
        if ($_GET["page_num"] < 0)
            $page_num = $_GET["page_num"];
        return $page_num;
    }
}

//ページネーションの総ページ数を取得
function get_max_page_num($pagination_limit, $catalog_num)
{
    $max_page_num = ceil($catalog_num / $pagination_limit);
    return $max_page_num;
}

//1ページ当たりの表示件数の管理
function getViewLimit()
{
    if (isset($_GET["limit"])) {
        //GETパラメータの数値が正しければそのまま使用
        $limit = $_GET["limit"];
        $pattern = '/^[1-9][0-9]*$/';
        if (preg_match($pattern, $limit) && DEFAULT_PAGINATION_MAX_LIMIT >= $limit && 0 < $limit) {
            $pagination_limit = $_GET["limit"];
            return $pagination_limit;
        } else {
            //GETパラメータがない、もしくは不正な場合デフォルト値を使用
            $pagination_limit = DEFAULT_PAGINATION_LIMIT;
            return $pagination_limit;
        }
    } else {
        //GETパラメータがない、もしくは不正な場合デフォルト値を使用
        $pagination_limit = DEFAULT_PAGINATION_LIMIT;
        return $pagination_limit;
    }
}