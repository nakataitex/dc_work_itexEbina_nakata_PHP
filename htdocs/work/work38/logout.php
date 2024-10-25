<?php
session_start();

unset($_COOKIE["user_name"]);
unset($_SESSION["user_name"]);

header("location:./login.php");
exit();