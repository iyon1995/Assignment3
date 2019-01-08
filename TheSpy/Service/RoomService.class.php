<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 9:38 PM
 * Version: 1.0
 * Description: Process affair relate to User
 */

require_once '../Entity/Room.class.php';
require_once '../DAO/DataProcessor.class.php';

class RoomService
{
    /**
     * Create a room
     * 1.if all room occupy then system will create a new room
     * 2.if there is an empty room, then system will assign the room to user.
     * @param $roomType
     * @param $playerNum
     * @param $isRreveal
     * @param $difficulty
     * @param $password
     * @param $owner
     * @return int
     */
    function createRoom($roomType,$playerNum,$isRreveal,$difficulty,$password,$owner){
        $roomId = "";
        $room = new Room($roomId,$roomType,$playerNum,$isRreveal,$difficulty,$password,"I",$owner);
        $sql = "select max(t.ID) from T_ROOM_MDL t where t.STATUS = 'N'";
        $dataProcessor = new DataProcessor();
        $roomId = $dataProcessor -> execute_dql($sql) -> fetch_row()[0];
        if($roomId == ""){
            $sql = "insert into T_ROOM_MDL(ROOM_TP,PLAYER_NUM,GAME_MODE,WORD_MODE,PASSWORD,STATUS,OWNER) values (?,?,?,?,?,?,?);";
        }else{
            $room -> setRoomId($roomId);
            $sql = "update T_ROOM_MDL set ROOM_TP=?,PLAYER_NUM=?,GAME_MODE=?,WORD_MODE=?,PASSWORD=?,STATUS=?,OWNER=? where ID = ?";
        }
        $isSucc = $dataProcessor -> generateRoom($sql,$room);
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    /**
     * Get detail information of a room
     * @param $getRoomInfoBy
     * @return Room
     */
    function getRoomInfo($getRoomInfoBy){
        $sql = "select t.ID,t.ROOM_TP,t.PLAYER_NUM,t.GAME_MODE,t.WORD_MODE,t.PASSWORD,t.STATUS,t.OWNER from T_ROOM_MDL t where t.OWNER = ? or t.ID = ? and t.STATUS != 'N'";
        $dataProcessor = new DataProcessor();
        $room = $dataProcessor -> getRoomInfo($sql,$getRoomInfoBy);
        $dataProcessor -> conn_close();
        return $room;
    }

    /**
     * Search a room by ID
     * @param $roomId
     * @return Room
     */
    function searchRoom($roomId){
        $sql = "select ID,PASSWORD from T_ROOM_MDL where ID=?;";
        $dataProcessor = new DataProcessor();
        $room = $dataProcessor -> searchRoom($sql,$roomId);
        $dataProcessor -> conn_close();

        return $room;
    }

    /**
     * Match a initial room which is Public and without Password
     * @return mixed
     */
    function matchRoom(){
        $sql = "select t.ID from T_ROOM_MDL t where t.STATUS = 'I' and t.PASSWORD = '' and t.ROOM_TP = 'Pu' limit 1;";
        $dataProcessor = new DataProcessor();
        $res = $dataProcessor -> execute_dql($sql);
        $roomId = $res -> fetch_row()[0];
        $res -> free();
        $dataProcessor -> conn_close();

        return $roomId;
    }

    /**
     * Create a game table for players to join in
     * @param $roomId
     * @param $userId
     * @return int
     */
    function generateGame($roomId,$userId){
        $sql = "create table if not exists TEMP_ROOM_" .$roomId ."(
                ID int AUTO_INCREMENT primary key comment 'id',
                PLAYER varchar(32) comment 'player id',
                ROOM_ID int comment 'room id',
                STATUS char(1) comment 'status',
                IS_SPY char(1) comment 'spy',
                VOTE int comment 'vote'
            ) comment = 'temp table';";

        $dataProcessor = new DataProcessor();
        $dataProcessor -> execute_dml($sql);
        $dataProcessor -> conn_close();
        $isSucc = $this -> joinGame($roomId,$userId);
        return $isSucc;
    }

    /**
     * Join in the Game
     * @param $roomId
     * @param $userId
     * @return int
     */
    function joinGame($roomId,$userId){
        $sqlM = "select t.PLAYER_NUM from T_ROOM_MDL t where ID = ?";
        $sqlC = "select count(t.ID) from TEMP_ROOM_".$roomId." t;";
        $dataProcessor = new DataProcessor();
        $diff = $dataProcessor -> isFull($sqlM,$sqlC,$roomId);
        if($diff > 0){
            $sql = "insert into TEMP_ROOM_".$roomId."(PLAYER,ROOM_ID,STATUS,VOTE) values (?,?,'N',0);";
            $isSucc = $dataProcessor -> joinGame($sql,$roomId,$userId);
        }else{
            $isSucc = 0;
        }
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    /**
     * Get all palyers id in the room
     * @param $roomId
     * @return array
     */
    function getPlayers($roomId){
        $sql = "select t.PLAYER from TEMP_ROOM_".$roomId." t ;";
        $dataProcessor = new DataProcessor();
        $players = array();
        $players = $dataProcessor -> getPlayers($sql);
        $dataProcessor -> conn_close();

        return $players;
    }


    /**
     * Drop game table and return the room to system
     * @param $roomId
     */
    function dropRoom($roomId){
        $sql = "drop table TEMP_ROOM_".$roomId.";";
        $dataProcessor = new DataProcessor();
        $dataProcessor -> execute_dml($sql);
        $sql = "update T_ROOM_MDL set ROOM_TP = NULL,PLAYER_NUM = NULL,GAME_MODE = NULL,";
        $sql .= "WORD_MODE = NULL,PASSWORD = NULL,STATUS = 'N',OWNER = NULL,RESULT = NULL,WORD_ID = NULL ";
        $sql .= "where ID = ?";
        $dataProcessor -> ownerLeftRoom($sql,$roomId);
        $dataProcessor -> conn_close();

    }

    /**
     * For Players to ask whether the game is over
     * (for the situation the Owner left room illegally)
     * @param $roomId
     * @return mixed
     */
    function isEnd($roomId){
        $sql = "select t.STATUS from T_ROOM_MDL t where t.ID = ?; ";
        $dataProcessor = new DataProcessor();
        $status = $dataProcessor -> isEnd($sql,$roomId);
        $dataProcessor -> conn_close();
        return $status;
    }

}


