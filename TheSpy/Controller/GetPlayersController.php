<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/26/2018
 * Time: 5:04 PM
 * Version:
 * Description:
 */
require_once '../Service/RoomService.class.php';
if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}
$roomService = new RoomService();
$players = $roomService -> getPlayers($roomId);

$playerLst = '[';
foreach ($players as $key => $val){
    $playerLst .= '{"userId":"'.$val.'"}';
    file_put_contents("../log/ajaxTest.txt","echo " .$val."\r\n",FILE_APPEND);
    if($key < count($players) - 1){
        $playerLst .= ',';
    }
}
$playerLst .= ']';
file_put_contents("../log/ajaxTest.txt","echo " .$playerLst."\r\n",FILE_APPEND);
echo $playerLst;



?>