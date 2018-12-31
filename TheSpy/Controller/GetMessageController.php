<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/28/2018
 * Time: 5:45 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/GameService.class.php';
require_once '../Entity/Message.class.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}


$userId = getCookieVal("userId");

$gameService = new GameService();

$messages = $gameService -> getMessage($roomId,$userId);

$mess = '[';
foreach ($messages as $key => $val){
    $mess .= '{';
    $mess .= '"messId":"' .$val -> getMessId(). '",';
    $mess .= '"roomId":"' .$val -> getRoomId(). '",';
    $mess .= '"sender":"' .$val -> getSender(). '",';
    $mess .= '"receiver":"' .$val -> getReceiver(). '",';
    $mess .= '"content":"' .$val -> getContent(). '",';
    $mess .= '"sendTime":"' .$val -> getSendTime(). '"}';
    if($key != count($messages)-1){
        $mess .= ',';
    }
}
$mess .= ']';
echo $mess;
?>