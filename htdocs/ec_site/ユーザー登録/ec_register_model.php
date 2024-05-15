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

function duplicate_check($count_function,$errors){
    if($count_function[0]["cnt"] > 0){
        $errors[] = "duplicate";
    }
    return $errors;
    }


/**
 * 新規登録フォームにエラーメッセージを表示する
 * 
 * @param string
 * @param array
 * 
 */


function display_form_error($errorType, $errors)
{
    if (isset($errors[$errorType])) {
        foreach ($errors[$errorType] as $error) {
            if ($error === "blank") {
                echo '<p class="error">' . MSG_ERR_BLANK;
                if ($errorType === "name") {
                    echo MSG_ERR_LENGTH_NAME;
                } else if ($errorType === "password") {
                    echo MSG_ERR_LENGTH_PASSWORD;
                }
                echo '</p>';
            } elseif ($error === "length") {
                echo '<p class="error">';
                if ($errorType === "name") {
                    echo MSG_ERR_LENGTH_NAME;
                } else if ($errorType === "password") {
                    echo MSG_ERR_LENGTH_PASSWORD;
                }
                echo '</p>';
            } elseif ($error === "string") {
                echo '<p class="error">' . MSG_ERR_STRING . '</p>';
            }
            if($error === "duplicate"){
                echo '<p class="error">'.MSG_ERR_DUPLICATE.'</p>';
            }
        }
    }
}