<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 4:38 PM
 * Version:
 * Description:
 */

require_once '../Service/UserService.class.php';
require_once '../tools/CookieTools.php';

$userid = "";
if(!empty($_POST['userid'])){
    $userid = $_POST['userid'];
}
$password = "";
if(!empty($_POST['password'])){
    $password = $_POST['password'];
    $password = md5($password);
}

if($userid != "" && $password != ""){
    $userService = new UserService();
    $isSucc = $userService -> loginService($userid,$password);
    if($isSucc == "S"){
        setLogin($userid);
        header("Location: ../pages/LivingRoom.html");
        exit();
    }else{
        header("Location: ../Login.html?errno=1");
        exit();
    }
}



?>