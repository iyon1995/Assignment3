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
require_once '../tools/CookieTools.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

if(!empty($_POST['candidate'])){
    $candidate= $_POST['candidate'];
}

$userId = getCookieVal("userId");

$gameService = new GameService();

$isSucc = $gameService -> vote($roomId,$userId,$candidate);

if($isSucc != 0){
    $status = '{"status":"V"}';
    echo $status;
}
?>