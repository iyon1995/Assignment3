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
require_once '../Service/GameService.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

$userId = getCookieVal("userId");

$gameService = new GameService();
$gameService -> suicide($userId,$roomId);

$roomService = new RoomService();
$owner = getCookieVal("owner");
if($owner != ""){
    $roomService -> dropRoom($roomId);
}

$exp = getCookieVal("exp");
$userService = new UserService();
$userService -> setExp($userId,$exp);


delCookie("owner");
delCookie("isJoin");
delCookie("turn");
delCookie("exp");

echo "left";


?>