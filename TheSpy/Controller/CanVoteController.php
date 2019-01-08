<?php
/**
 * Created by PhpStorm.
 * Author: xiyuan.wang
 * Date: 12/29/2018
 * Time: 4:25 PM
 * Version: 1.0
 * Description: For user to ask if he can vote
 */
require_once '../Service/GameService.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
    $roomId = checkSpecialChar($roomId);
}

$gameService = new GameService();

$status = $gameService -> canVote($roomId);

if($status == "V"){
    $status = '{"status":"' .$status. '"}';
    echo $status;
}
?>