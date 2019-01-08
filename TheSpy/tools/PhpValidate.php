<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/8/2019
 * Time: 10:52 PM
 * Version:
 * Description:
 */

function checkSpecialChar($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkPassword($data){
    $data = trim($data);
    return $data;
}
?>