<?php
/**
 * Created by PhpStorm.
 * User: wangxiyuanflora
 * Date: 2018-12-26
 * Time: 18:50
 */

require_once '../Service/RoomService.class.php';
require_once '../Entity/Room.class.php';

//file_put_contents("../log/ajaxTest.txt","echo " ." hh "."\r\n",FILE_APPEND);


$roomService = new RoomService();
if(!empty($_POST["roomId"])){
    $roomId = $_POST["roomId"];
}
$room = $roomService -> searchRoom($roomId);


if($room){
    //echo $room -> getPassword()."aaa";

    $roomInfo = '{"roomId":"'.$room -> getRoomId().'",';
    $roomInfo .= '"roomPassword":"'.$room -> getPassword().'"}';
    //file_put_contents("../log/ajaxTest.txt","echo " .$roomInfo."\r\n",FILE_APPEND);



}else{

    $room = "bbb";
}


echo $roomInfo;
?>
