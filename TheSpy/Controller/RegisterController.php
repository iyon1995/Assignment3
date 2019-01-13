<?php
/**
 * Created by PhpStorm.
 * User: wangxiyuanflora
 * Date: 2019-01-06
 * Time: 00:44
 */

require_once '../Service/UserService.class.php';
require_once '../tools/PhpValidate.php';


if(!empty($_POST["userId"])){
    $userId = $_POST["userId"];
}

if(!empty($_POST["userName"])){
    $userName = $_POST["userName"];
}

if(!empty($_POST["password"])){
    $password = $_POST["password"];
}

//file_put_contents("../log/ajaxTest.txt","echo " .$userId."--".$userName."--".$password."\r\n",FILE_APPEND);

$userService = new UserService();
$isSucc = $userService -> register($userId,$userName,$password);

if($isSucc != 1){
    echo '{"errMess":"This email has already been registered"}';
}else{
    echo '{"errMess":""}';
}


