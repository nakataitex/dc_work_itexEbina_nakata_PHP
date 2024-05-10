<?php
/**
 * ログインID省略のcookieが保存されていたら自動入力
 * @param array
 * @return array
 */
function cookie_read($_COOKIE)
{
    if (isset($_COOKIE['cookie_confirmation']) === TRUE) {
        $cookie_confirmation = "checked";
    } else {
        $cookie_confirmation = "";
    }
    if (isset($_COOKIE['login_id']) === TRUE) {
        $login_id = $_COOKIE['login_id'];
    } else {
        $login_id = '';
    }

    return [$cookie_confirmation,$login_id];
}

/**
 * 
 * 
 * 
 */

//POSTされたフォームの値を変数に格納する
if (isset($_POST['cookie_confirmation']) === TRUE) {
    $cookie_confirmation = $_POST['cookie_confirmation'];
} else {
    $cookie_confirmation = '';
}
if (isset($_POST['login_id']) === TRUE) {
    $login_id = $_POST['login_id'];
} else {
    $login_id = '';
}

// ログインIDの入力省略にチェックがされている場合はCookieを保存
if ($cookie_confirmation === 'checked') {
    setcookie('cookie_confirmation', $cookie_confirmation, $cookie_expiration);
    setcookie('login_id', $login_id, $cookie_expiration);
} else {
    // チェックされていない場合はCookieを削除する
    setcookie('cookie_confirmation', '', time() - 30);
    setcookie('login_id', '', time() - 30);
}