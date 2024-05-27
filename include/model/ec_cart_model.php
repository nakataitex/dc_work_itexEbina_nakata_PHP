<?php
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

//ユーザーが選択した商品をカーとから削除する為の関数
function delete_from_cart($product_id, $user_id)
{
    $sql =
        'DELETE FROM ec_cart_table 
WHERE product_id = :product_id AND user_id = :user_id';
    $param = [
        ":product_id" => $product_id,
        ":user_id" => $user_id
    ];
    return sql_fetch_data($sql, $param);
}