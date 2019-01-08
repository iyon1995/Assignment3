<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 5:03 PM
 * Version:1.0
 * Description: Process affair relate to User
 */
require_once '../Entity/User.class.php';
require_once '../DAO/DataProcessor.class.php';

class UserService
{
    /**
     * Check if user is a legal user
     * @param $userId
     * @param $password
     * @return isSucc
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

    /**
     * Register an account
     * @param $userId
     * @param $userName
     * @param $password
     */
    public function register($userId,$userName,$password){
        $isUni = $this -> uniqueEmail();
        if($isUni == 1){
            $user = new User($userId,$userName,$password,"S");
            $sql = "insert into T_USER_MDL (ID,USER_NAME,PASSWORD,STATUS) values(?,?,md5(?),?);";
            $dao = new DataProcessor();
            $dao -> register($sql,$user);
            $dao -> conn_close();
            $isSucc = 1;
        }else{
            $isSucc = 0;
        }
        return $isSucc;
    }

    /**
     * Check if the email has been registered
     * @param $userId
     */
    public function uniqueEmail($userId){
        $sql = "select t.id from T_USER_MDL t where t.ID = ?";
        $dao = new DataProcessor();
        $id = $dao -> uniqueEmail($sql,$userId);
        $dao -> conn_close();
        if($id != ""){
            $isUni = 0;
        }else{
            $isUni = 1;
        }
        return $isUni;
    }


    /**
     * Get detail information of users
     * @param $players
     * @return array
     */
    function getPlatersInfo($players){
        $sql = "select t.USER_NAME,t.LEVEL,t.G_ROUND,t.GW_ROUND,t.GWS_ROUND from T_USER_MDL t where t.ID = ?;";
        $dataProcessor = new DataProcessor();
        $users = array();
        foreach ($players as $key => $val){
            $player = $dataProcessor -> getPlayersInfo($sql,$val);
            array_push($users,$player);
        }
        $dataProcessor -> conn_close();
        return $users;
    }


    /**
     * Modify the level of the User
     * @param $userId
     * @param $exp
     */
    public function setExp($userId,$exp){
        $sql = "update T_USER_MDL set LEVEL = LEVEL + ? where ID = ?";
        $dataProcessor = new DataProcessor();
        $dataProcessor -> settleExp($sql,$userId,$exp);
        $dataProcessor -> conn_close();
    }

    /**
     * Summary data of user in one game
     * @param $userId
     * @param $exp
     * @param $result
     */
    public function settleAccounts($userId,$exp,$result){
        $sql = "update T_USER_MDL set LEVEL = LEVEL + ?,G_ROUND = G_ROUND + 1,GW_ROUND = GW_ROUND + ?,GWS_ROUND = GWS_ROUND + ? where ID = ?";
        $dataProcessor = new DataProcessor();
        $dataProcessor -> settleAccounts($sql,$userId,$exp,$result);
        $dataProcessor -> conn_close();
    }


}
