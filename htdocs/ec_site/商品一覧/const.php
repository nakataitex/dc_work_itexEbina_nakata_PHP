<?
//定数を記述

//例:define('CONSTANT', 'Hello world.');
//CONSTANT;  Hello world.を出力
define('DSN', 'mysql:host=localhost;dbname=xb513874_u338x');
define('LOGIN_USER', 'xb513874_fpu2g');
define('PASSWORD', 'mj3mt8vtwv');


//商品管理ページのSQL
define("PRODUCT_MANAGEMENT", "SELECT
    *
    FROM
        ec_product_table
        INNER JOIN ec_image_table
        ON ec_product_table.product_id = ec_image_table.product_id 
        JOIN ec_stock_table 
        ON ec_image_table.product_id = ec_stock_table.product_id;");


//Cookieの保存期間
define('EXPIRATION_PERIOD', 30);