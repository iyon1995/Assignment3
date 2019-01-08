<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/27/2018
 * Time: 4:52 PM
 * Version: 1.0
 * Description: For Owner to start game
 */
require_once '../Service/GameService.class.php';
require_once '../Entity/Room.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
    $roomId = checkSpecialChar($roomId);
}

if(!empty($_POST['playerNum'])){
    $playerNum = $_POST['playerNum'];
    $playerNum = checkSpecialChar($playerNum);
}

if(!empty($_POST['difficulty'])){
    $difficulty = $_POST['difficulty'];
    $difficulty = checkSpecialChar($difficulty);
}

$room = new Room($roomId,$playerNum,$difficulty);

$gameService = new GameService();
$isSucc = $gameService -> iniGame($room);
if($isSucc != 0){
    echo '{"status":"D"}';
}
?>