<?php
function form_check($data)
{
    $match_value = '/^[A-Za-z0-9]+$/';
    foreach ($data as $key => $value) {
        echo "キー: " . $key . ", 値: " . $value . "\n";
        echo "$data";
    }
}
