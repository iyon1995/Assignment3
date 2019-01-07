<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 4:45 PM
 * Version: 1.0
 * Description: store info of user
 */
class User
{

    private $userId;
    private $userName;
    private $password;
    private $level;
    private $gRound;
    private $gwRound;
    private $gwsRound;
    private $friendLst;
    private $status;


    public function __construct()
    {
        $a=func_get_args();
        $i=func_num_args();
        if(method_exists($this,$f='__construct'.$i)){
            call_user_func_array(array($this,$f),$a);
        }
    }

    public function __construct2($userId,$password)
    {
        $this -> userId = $userId;
        $this -> password = $password;
    }

    public function __construct9($userId,$userName,$password,$level,$gRound,$gwRound,$gwsRound,$friendLst,$status)
    {
        $this -> userId = $userId;
        $this -> userName = $userName;
        $this -> password = $password;
        $this -> level = $level;
        $this -> gRound = $gRound;
        $this -> gwRound = $gwRound;
        $this -> gwsRound = $gwsRound;
        $this -> friendLst = $friendLst;
        $this -> status = $status;
    }

    public function __construct3($userId,$userName,$status)
    {
        $this -> userId = $userId;
        $this -> userName = $userName;
        $this -> status = $status;
    }

    public function __construct6($userId,$userName,$level,$gRound,$gwRound,$gwsRound)
    {
        $this -> userId = $userId;
        $this -> userName = $userName;
        $this -> level = $level;
        $this -> gRound = $gRound;
        $this -> gwRound = $gwRound;
        $this -> gwsRound = $gwsRound;
    }

    public function __construct8($userId,$userName,$level,$gRound,$gwRound,$gwsRound,$friendLst,$status)
    {
        $this -> userId = $userId;
        $this -> userName = $userName;
        $this -> level = $level;
        $this -> gRound = $gRound;
        $this -> gwRound = $gwRound;
        $this -> gwsRound = $gwsRound;
        $this -> friendLst = $friendLst;
        $this -> status = $status;
    }

    //getters and setters


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getGRound()
    {
        return $this->gRound;
    }

    /**
     * @param mixed $gRound
     */
    public function setGRound($gRound)
    {
        $this->gRound = $gRound;
    }

    /**
     * @return mixed
     */
    public function getGwRound()
    {
        return $this->gwRound;
    }

    /**
     * @param mixed $gwRound
     */
    public function setGwRound($gwRound)
    {
        $this->gwRound = $gwRound;
    }

    /**
     * @return mixed
     */
    public function getGwsRound()
    {
        return $this->gwsRound;
    }

    /**
     * @param mixed $gwsRound
     */
    public function setGwsRound($gwsRound)
    {
        $this->gwsRound = $gwsRound;
    }

    /**
     * @return mixed
     */
    public function getFriendLst()
    {
        return $this->friendLst;
    }

    /**
     * @param mixed $friendLst
     */
    public function setFriendLst($friendLst)
    {
        $this->friendLst = $friendLst;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


}