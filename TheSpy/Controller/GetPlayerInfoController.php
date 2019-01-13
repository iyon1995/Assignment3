<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/12/2019
 * Time: 3:36 PM
 * Version:
 * Description:
 */

require_once '../tools/CookieTools.php';
require_once '../Service/UserService.class.php';
require_once '../Entity/User.class.php';

$userId = getCookieVal("userId");
$players = array($userId);

$userService = new UserService();

$users = $userService -> getPlatersInfo($players);
$thisUser = $users[0];

$playerInfo = '{"userId":"'.$thisUser -> getUserId().'",';
$playerInfo .= '"userName":"'.$thisUser -> getUserName().'",';
$playerInfo .= '"level":"'.$thisUser -> getLevel().'",';
$playerInfo .= '"gRound":"'.$thisUser -> getGRound().'",';
$playerInfo .= '"gWRound":"'.$thisUser -> getGwRound().'",';
$playerInfo .= '"gWSRound":"'.$thisUser -> getGwsRound().'"}';

echo $playerInfo;

?>