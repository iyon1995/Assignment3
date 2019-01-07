<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/24/2018
 * Time: 2:56 PM
 * Version:
 * Description:
 */

require_once '../Service/RoomService.class.php';
require_once '../Entity/Room.class.php';
require_once '../tools/CookieTools.php';

if(!empty($_POST['getRoomInfo'])){
    $getRoomInfoBy = $_POST['getRoomInfo'];
}
if($getRoomInfoBy == 'owner'){
    $getRoomInfoBy = getCookieVal("owner");
}

setExp("i");

$userId = getCookieVal("userId");

file_put_contents("../log/ajaxTest.txt","echo " .$getRoomInfoBy."--".$userId."\r\n",FILE_APPEND);

$roomService = new RoomService();
$room = $roomService -> getRoomInfo($getRoomInfoBy);
if(empty($_COOKIE['isJoin'])){
    file_put_contents("../log/ajaxTest.txt","echo " .$room -> getRoomId()."--".$room -> getRoomType()."\r\n",FILE_APPEND);
    $isSucc = $roomService -> generateGame($room -> getRoomId(),$userId);
    if($isSucc == 0){
        header("Location: ../pages/LivingRoom.html?errno=2");
        exit();
    }else{
        joinInRoom();
    }
}

$roomInfo = '{';
$roomInfo .= '"roomId":"'.$room -> getRoomId() . '",';
$roomInfo .= '"roomTpye":"'.$room -> getRoomType() . '",';
$roomInfo .= '"playerNum":"'.$room -> getPlayerNum() . '",';
$roomInfo .= '"isRreveal":"'.$room -> getisRreveal() . '",';
$roomInfo .= '"difficulty":"'.$room -> getDifficulty() . '",';
$roomInfo .= '"status":"'.$room -> getStatus() . '",';
$roomInfo .= '"owner":"'.$room -> getOwner() . '"}';
file_put_contents("../log/ajaxTest.txt","echo " .$roomInfo ."\r\n",FILE_APPEND);
echo $roomInfo;



?>