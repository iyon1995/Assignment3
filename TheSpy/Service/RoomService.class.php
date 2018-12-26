<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/23/2018
 * Time: 9:38 PM
 * Version:
 * Description:
 */

require_once '../Entity/Room.class.php';
require_once '../DAO/DataProcessor.class.php';

class RoomService
{
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

    function getRoomInfo($getRoomInfoBy){
        $sql = "select t.ID,t.ROOM_TP,t.PLAYER_NUM,t.GAME_MODE,t.WORD_MODE,t.PASSWORD,t.STATUS,t.OWNER from T_ROOM_MDL t where t.OWNER = ? or t.ID = ? and t.STATUS = 'I'";
        $dataProcessor = new DataProcessor();
        $room = $dataProcessor -> getRoomInfo($sql,$getRoomInfoBy);
        $dataProcessor -> conn_close();
        return $room;
    }

    function searchRoom($roomId){
        $sql = "select ID,PASSWORD from T_ROOM_MDL where ID=?;";
        $dataProcessor = new DataProcessor();
        $room = $dataProcessor -> searchRoom($sql,$roomId);
        $dataProcessor -> conn_close();

        return $room;
    }

    function generateGame($roomId,$userId){
        $sql = "create table if not exists TEMP_ROOM_" .$roomId ."(
                ID int AUTO_INCREMENT primary key comment 'id',
                PLAYER varchar(32) comment 'player id',
                ROOM_ID int comment 'room id',
                STATUS char(1) comment 'status',
                VOTE int comment 'vote'
            ) comment = 'temp table';";

        $dataProcessor = new DataProcessor();
        $dataProcessor -> execute_dml($sql);
        $dataProcessor -> conn_close();
        $this -> joinGame($roomId,$userId);
    }

    function joinGame($roomId,$userId){
        $sqlM = "select t.PLAYER_NUM from T_ROOM_MDL t where ID = ?";
        $sqlC = "select count(t.ID) from TEMP_ROOM_".$roomId." t;";
        $dataProcessor = new DataProcessor();
        $diff = $dataProcessor -> isFull($sqlM,$sqlC,$roomId);
        if($diff > 0){
            $sql = "insert into TEMP_ROOM_".$roomId."(PLAYER,ROOM_ID,STATUS,VOTE) values (?,?,'D',0);";
            $isSucc = $dataProcessor -> joinGame($sql,$roomId,$userId);
        }else{
            $isSucc = 0;
        }
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    function getPlayers($roomId){
        $sql = "select t.PLAYER from TEMP_ROOM_".$roomId." t;";
        $dataProcessor = new DataProcessor();
        $players = array();
        $players = $dataProcessor -> getPlayers($sql);
        $dataProcessor -> conn_close();

        return $players;
    }
}


