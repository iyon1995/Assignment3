<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 9:53 PM
 * Version:
 * Description:
 */
class Room
{
    private $roomId;
    private $roomType;
    private $playerNum;
    private $isRreveal;
    private $difficulty;
    private $password;
    private $status;
    private $owner;
    private $result;


    public function __construct()
    {
        $a=func_get_args();
        $i=func_num_args();
        if(method_exists($this,$f='__construct'.$i)){
            call_user_func_array(array($this,$f),$a);
        }
    }

    public function __construct8($roomId,$roomType,$playerNum,$isRreveal,$difficulty,$password,$status,$owner){

        $this -> roomId = $roomId;
        $this -> roomType = $roomType;
        $this -> playerNum = $playerNum;
        $this -> isRreveal = $isRreveal;
        $this -> difficulty = $difficulty;
        $this -> password = $password;
        $this -> status = $status;
        $this -> owner = $owner;
    }

    public function __construct2($roomId,$password){
        $this -> roomId = $roomId;
        $this -> password = $password;
    }

    public function __construct3($roomId,$playerNum,$difficulty){
        $this -> roomId = $roomId;
        $this -> difficulty = $difficulty;
        $this -> playerNum = $playerNum;
    }


    // getter and setter

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return mixed
     */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /**
     * @param mixed $roomTpye
     */
    public function setRoomTpye($roomType)
    {
        $this->roomType = $roomType;
    }

    /**
     * @return mixed
     */
    public function getPlayerNum()
    {
        return $this->playerNum;
    }

    /**
     * @param mixed $playerNum
     */
    public function setPlayerNum($playerNum)
    {
        $this->playerNum = $playerNum;
    }

    /**
     * @return mixed
     */
    public function getisRreveal()
    {
        return $this->isRreveal;
    }

    /**
     * @param mixed $isRreveal
     */
    public function setIsRreveal($isRreveal)
    {
        $this->isRreveal = $isRreveal;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;
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

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }



}