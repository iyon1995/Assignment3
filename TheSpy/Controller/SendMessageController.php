<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/28/2018
 * Time: 5:11 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/GameService.class.php';
require_once '../Service/RoomService.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

if(!empty($_POST['content'])){
    $content = $_POST['content'];
}

$userId = getCookieVal("userId");
$roomService = new RoomService();
$players = $roomService -> getPlayers($roomId);
$gameService = new GameService();
$isSucc = $gameService -> sendMessage($roomId,$userId,$players,$content);
//$isSucc = $gameService -> sendMessage(46,$userId,$players,"test");
if($isSucc != 0){
    echo '{"isSucc":"S","userId":"' . $userId . '"}';
}
?>