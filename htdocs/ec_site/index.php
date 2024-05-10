<?php
require_once("const.php");//定数
require_once("ec_site_model.php");//model

$cookie_check = cookie_read($_COOKIE);

//ログイン画面表示→ログイン出来てたらホーム画面
include("login.php");