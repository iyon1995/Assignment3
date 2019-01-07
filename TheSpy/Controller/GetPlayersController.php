<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/26/2018
 * Time: 5:04 PM
 * Version:
 * Description:
 */
require_once '../Service/RoomService.class.php';
require_once '../Service/UserService.class.php';
require_once '../Entity/User.class.php';
if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}
$roomService = new RoomService();
$players = $roomService -> getPlayers($roomId);

$userService = new UserService();
$users = $userService -> getPlatersInfo($players);

$playerLst = '[';
foreach ($users as $key => $val){
    $playerLst .= '{"userId":"'.$val -> getUserId().'",';
    $playerLst .= '"userName":"'.$val -> getUserName().'",';
    $playerLst .= '"level":"'.$val -> getLevel().'",';
    $playerLst .= '"gRound":"'.$val -> getGRound().'",';
    $playerLst .= '"gWRound":"'.$val -> getGwRound().'",';
    $playerLst .= '"gWSRound":"'.$val -> getGwsRound().'"}';
    if($key < count($players) - 1){
        $playerLst .= ',';
    }
}
$playerLst .= ']';
file_put_contents("../log/ajaxTest.txt","echo " .$playerLst."\r\n",FILE_APPEND);
echo $playerLst;



?>