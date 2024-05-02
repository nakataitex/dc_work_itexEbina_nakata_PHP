<?php
$dsn = 'mysql:host=localhost;dbname=xb513874_u338x';
$login_user = 'xb513874_fpu2g';
$password = 'mj3mt8vtwv';

    //接続
    try {
        $db = new PDO($dsn, $login_user, $password);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }