<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 8:54 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/RoomService.class.php';

if(!empty($_POST['room_type'])){
    $roomType = $_POST['room_type'];
}

if(!empty($_POST['is_reveal'])){
    $isRreveal = $_POST['is_reveal'];
}

if(!empty($_POST['difficulty'])){
    $difficulty = $_POST['difficulty'];
}

if(!empty($_POST['player_num'])){
    $player_num = $_POST['player_num'];
}
if(!empty($_POST['password'])){
    $password = $_POST['password'];
}

$userId = getCookieVal("userId");

$roomService = new RoomService();

$isSucc = $roomService -> createRoom($roomType,$player_num,$isRreveal,$difficulty,$password,$userId);

if($isSucc != 0){
    //room create successfully
    setOwner($userId);
    header("Location: ../pages/Charmber.html");
    exit();
}else {
    header("Location: ../pages/LivingRoom.html?errno=2");
    exit();
}

?>