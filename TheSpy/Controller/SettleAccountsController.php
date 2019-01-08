<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/2/2019
 * Time: 10:08 PM
 * Version:
 * Description:
 */
require_once '../tools/CookieTools.php';
require_once '../Service/UserService.class.php';
require_once '../tools/PhpValidate.php';

if(!empty($_POST['isSpy'])){
    $isSpy = $_POST['isSpy'];
}

if(!empty($_POST['isWin'])){
    $isWin = $_POST['isWin'];
}
$result = array("isWin" => 0,"isSpyWin" => 0);
if ($isWin != "L"){
    $result["isWin"] = 1;
    if($isSpy == "S"){
        $result["isSpyWin"] = 1;
    }
    setExp("w");
}else{
    setExp("l");
}

$exp = getCookieVal("exp");


$userService = new UserService();
$userService -> settleAccounts($userId,$exp,$result);


?>