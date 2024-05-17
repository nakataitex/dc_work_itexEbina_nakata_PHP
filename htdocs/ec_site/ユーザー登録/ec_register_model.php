<?php

/**
 * フォームチェック
 * 名前とパスワードのチェックを行う
 * 
 * 
 */
function validation($input, $min_length)
{
    $errors = [];
    if ($input === "") {
        $errors[] = "blank";
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $input)) {
        $errors[] = "string";
    }
    if ($input !== "" && strlen($input) < $min_length) {
        $errors[] = "length";
    }
    
    return $errors;
}

function duplicate_check($count_function,$array){
    if($count_function[0]["cnt"] > 0){
        $array[] = "duplicate";
    }
    return $array;
    }