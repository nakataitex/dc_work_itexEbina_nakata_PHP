<?php
//格納されたメッセージを定数を使って文章にする為のメッセージリスト
//type-category-status
$message_list = [
    "error" => [
        "db" => [
            "db_error" => ERR_DB_ERROR
        ],
        "login" => [
            "login_failed" => ERR_LOGIN_FAILED,
            "string" => USER_NAME . 'と' . PASSWORD . ERR_STRING
        ],
        "product_manage" => [
            "duplicate" => 'この' . PRODUCT_NAME . ERR_DUPLICATE,
            "name_blank" => PRODUCT_NAME . ERR_BLANK,
            "price_blank" => PRICE . ERR_BLANK,
            "qty_blank" => STOCK . ERR_BLANK,
            "file_type" => FILE_TYPE . ERR_INCORRECT,
            "upload" => IMAGE . ERR_UPLOAD,
            "image_blank" => IMAGE . ERR_SELECT,
            "public_flg" => PUBLIC_FLG . ERR_STATUS
        ],
        "name" => [
            "string" => USER_NAME . ERR_STRING,
            "length" => ERR_LENGTH_NAME,
            "duplicate" => USER_NAME . ERR_DUPLICATE
        ],
        "password" => [
            "string" => PASSWORD . ERR_STRING,
            "length" => ERR_LENGTH_PASSWORD,
        ],
    ],
    "normal" => [
        "product_manage" => [
            "add_product" => NORMAL_ADD_PRODUCT,
        ],
    ],
];