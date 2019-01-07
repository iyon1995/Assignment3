<?php
/**
 * Created by PhpStorm.
 * User: wangxiyuanflora
 * Date: 2019-01-06
 * Time: 00:44
 */

require_once '../Service/UserService.class.php';


if(!empty($_POST["email"])){
    $email = $_POST["email"];
}
if(!empty($_POST["spassword"])){
    $password = $_POST["spassword"];
}


$userService = new UserService();
$userService -> register($email,$email,$password);

header("Location: ../Login.html");
exit();

