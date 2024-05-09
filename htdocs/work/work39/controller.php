<?php
require_once("model.php");

$pdo = get_connection();
$image_data= get_image_list($pdo);

include_once("view.php");