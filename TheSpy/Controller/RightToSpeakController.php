<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/28/2018
 * Time: 4:47 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/GameService.class.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}
$userId = getCookieVal("userId");

$gameService = new GameService();
$canTalk = $gameService -> canISpeak($roomId,$userId);
$canTalk = '{"canTalk":"' .$canTalk .'"}';
echo $canTalk;


?>