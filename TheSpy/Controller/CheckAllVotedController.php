<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/29/2018
 * Time: 7:57 PM
 * Version: 1.0
 * Description: For owner to check if the all players have voted
 */

require_once '../tools/CookieTools.php';
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
$isSucc = 0;

$isOwner = getCookieVal("owner");
/*$roomId = 79;
$isSucc = 0;
$isOwner = "@iyon";
$playerNum = 3;*/
if($isOwner != ""){
    $gameService = new GameService();
    $count = $gameService -> checkAllVoted($roomId);
    $info = '{"status":"V"}';
    if($count == 0){
        $info = '{"status":"R"}';
        $dead = $gameService -> checkDead($roomId);
        $isSucc = $gameService -> setDead($dead[0],$roomId);
        $result = "$dead[0] ";
        if($dead[1] != "S"){
            $result .= "N ";
        }else{
            $result .= "S ";
        }

        $aLive = $gameService -> checkResult($roomId);
        $turn = getCookieVal("turn");
        if($aLive[0] != 0 && $turn == 4){
            $status = "R";
            $result .= "S";
        }else if($aLive[0] == 0 && $turn != 4){
            $status = "R";
            $result .= "N";
        }else if($aLive[1] == $aLive[0] && $turn != 4){
            $status = "R";
            $result .= "S";
        }else{
            $status = "D";
            $result .= "T";
            $room = new Room($roomId,$playerNum,"");
            $gameService -> nextRound($room);
        }
        $isSucc = $gameService -> setResult($roomId,$result,$status);
    }
    file_put_contents("../log/ajaxTest.txt",$info ." hh "."\r\n",FILE_APPEND);
    echo $info;
}else{
    echo '{"status":"R"}';
}






?>