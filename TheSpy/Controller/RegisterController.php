<?php
/**
 * Created by PhpStorm.
 * User: wangxiyuanflora
 * Date: 2019-01-06
 * Time: 00:44
 */

require_once '../Service/UserService.class.php';
require_once '../tools/PhpValidate.php';


if(!empty($_POST["email"])){
    $email = $_POST["email"];
}

if(!empty($_POST["userName"])){
    $userName = $_POST["userName"];
}

if(!empty($_POST["password"])){
    $password = $_POST["password"];
}


$userService = new UserService();
$isSucc = $userService -> register($email,$userName,$password);

if($isSucc != 1){
    echo '{"errMess":"This email has already been registered"}';
}else{
    echo '{"errMess":""}';
}


