<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 8:54 PM
 * Version: 1.0
 * Description: For Owner to create room
 */

require_once '../tools/CookieTools.php';
require_once '../Service/RoomService.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['room_type'])){
    $roomType = $_POST['room_type'];
    $roomType = checkSpecialChar($roomType);
}

if(!empty($_POST['is_reveal'])){
    $isRreveal = $_POST['is_reveal'];
    $isRreveal = checkSpecialChar($isRreveal);
}

if(!empty($_POST['difficulty'])){
    $difficulty = $_POST['difficulty'];
    $difficulty = checkSpecialChar($difficulty);
}

if(!empty($_POST['player_num'])){
    $player_num = $_POST['player_num'];
    $player_num = checkSpecialChar($player_num);
}
if(!empty($_POST['password'])){
    $password = $_POST['password'];
    $password = checkPassword($password);
}else{
    $password = "";
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