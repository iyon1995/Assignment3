<?php
/**
 * Created by PhpStorm.
 * Author: xiyuan.wang
 * Date: 12/29/2018
 * Time: 4:25 PM
 * Version:
 * Description:
 */
require_once '../Service/GameService.class.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

$gameService = new GameService();

$status = $gameService -> canVote($roomId);

if($status == "V"){
    $status = '{"status":"' .$status. '"}';
    echo $status;
}
?>