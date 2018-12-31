<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/27/2018
 * Time: 8:04 PM
 * Version:
 * Description: use for
 * 1.determine if game have started,
 * 2.if I am a spy and
 * 3.what is my word
 */

require_once '../Service/GameService.class.php';
require_once '../tools/CookieTools.php';


if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

$userId = getCookieVal("userId");


$gameService = new GameService();
$isStart = $gameService -> isStart($roomId);
if($isStart["status"] == "D"){
    $isSpy = $gameService -> amISpy($roomId,$userId);
    $sWord = $isStart[0]["S"];
    $nWord = $isStart[0]["N"];
    $info = '{"status":"'.$isStart["status"].'",';
    $info .= '"sWord":"'.$sWord.'",';
    $info .= '"nWord":"'.$nWord.'",';
    if($isSpy != "S"){
        $info .= '"isSpy":"N"}';
    }else{
        $info .= '"isSpy":"S"}';
    }
    setTurn(1);
    echo $info;
}

?>