<?php
/**
 * Created by PhpStorm.
 * Author: xiyuan.wang
 * Date: 12/29/2018
 * Time: 4:25 PM
 * Version: 1.0
 * Description: FOr players to get result
 */
require_once '../Service/GameService.class.php';
require_once '../tools/CookieTools.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
    $roomId = checkSpecialChar($roomId);
}
//$roomId = 56;
$gameService = new GameService();

$result = $gameService -> getResult($roomId);
if($result != ""){
    setTurn((int)getCookieVal("turn") + 1);
    $res='{"result":"' . $result . '",';
    $res.='"status":"D"}';
    echo $res;
}

?>