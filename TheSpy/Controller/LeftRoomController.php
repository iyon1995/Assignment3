<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/1/2019
 * Time: 9:20 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/RoomService.class.php';
require_once '../Service/UserService.class.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

$roomService = new RoomService();
$owner = getCookieVal("owner");
if($owner != ""){
    $roomService -> dropRoom($roomId);
}

$exp = getCookieVal("exp");
$userId = getCookieVal("$userId");
$userService = new UserService();
$userService -> setExp($userId,$exp);


delCookie("owner");
delCookie("isJoin");
delCookie("turn");
delCookie("exp");


?>