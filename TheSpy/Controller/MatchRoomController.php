<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/7/2019
 * Time: 6:23 PM
 * Version:
 * Description:
 */

require_once '../Service/RoomService.class.php';

$roomService = new RoomService();
$roomId = $roomService -> matchRoom();
if($roomId == ""){
    $roomId = 0;
}

$info = '{"roomId":"' . $roomId . '"}';
echo $info;
?>