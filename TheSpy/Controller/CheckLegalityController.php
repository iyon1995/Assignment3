<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/7/2019
 * Time: 4:53 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';

$location = "";
if(!empty($_POST['location'])){
    $location = $_POST['location'];
}
$errno = 0;
$isLegal = getCookieVal("userId");
if($isLegal == ""){
    $errno = 1;
}

if($location == "LivingRoom"){
    $isJoin = getCookieVal("isJoin");
    if($isJoin == "T"){
        delCookie("owner");
        delCookie("isJoin");
        delCookie("turn");
        delCookie("exp");
    }
}

$info = '{"errno":"' . $errno . '"}';

echo $info;


?>