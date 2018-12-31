<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/27/2018
 * Time: 4:52 PM
 * Version:
 * Description:
 */
require_once '../Service/GameService.class.php';
require_once '../Entity/Room.class.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

if(!empty($_POST['playerNum'])){
    $playerNum = $_POST['playerNum'];
}

if(!empty($_POST['difficulty'])){
    $difficulty = $_POST['difficulty'];
}

$room = new Room($roomId,$playerNum,$difficulty);

$gameService = new GameService();
$isSucc = $gameService -> iniGame($room);
if($isSucc != 0){
    echo '{"status":"D"}';
}
?>