<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 5:03 PM
 * Version:1.0
 * Description:
 */
require_once '../Entity/User.class.php';
require_once '../DAO/DataProcessor.class.php';

class UserService
{
    /**
     * check if user is a legal user
     * @param $userId
     * @param $password
     */
    public function loginService($userId,$password){
        $user = new User($userId,$password);
        $sql = "select t.password from T_USER_MDL t where ID = ?";
        $dao = new DataProcessor();
        $resPassword = $dao -> checkLogin($sql,$user);
        $isSucc = "F";
        if($password == $resPassword){
            $isSucc = "S";
        }
        $dao -> conn_close();
        return $isSucc;
    }

}