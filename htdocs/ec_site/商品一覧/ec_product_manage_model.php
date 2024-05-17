<?php
/**
 * 表示切替ボタンの文字列の割り当て
 * 
 * @param array
 * @return array
 */
function get_public_button_and_class($array)
{
    switch ($array["public_flg"]):
        case 0:
            $public_button = "表示する";
            $public_class = "private";
            $public_status = "非公開";
            break;
        case 1:
            $public_button = "非表示にする";
            $public_class = "public";
            $public_status = "公開";
            break;
        default:
            $public_button = "ステータス異常(非公開にする)";
            $public_class = "private";
            $public_status = "ステータス異常";
            break;
    endswitch;
    return ["public_button" => $public_button, "public_class" => $public_class, "public_status" => $public_status];
}

