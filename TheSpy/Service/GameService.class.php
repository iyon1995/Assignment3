<?php

/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/27/2018
 * Time: 5:06 PM
 * Version:
 * Description:
 */

require_once '../Entity/Room.class.php';
require_once '../DAO/DataProcessor.class.php';

class GameService
{
    function iniGame($room){
        $dataProcessor = new DataProcessor();
        //assign spy
        $this -> assignSpy($room,$dataProcessor);
        //choose word
        $wordId = $this -> chooseWord($room,$dataProcessor);
        //inital game
        $sql = "update T_ROOM_MDL set WORD_ID = ?,STATUS = 'D' where ID = ?;";
        $isSucc = $dataProcessor -> iniGame($sql,$room -> getRoomId(),$wordId);
        $this -> choosePlayerToStart($room,$dataProcessor);
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    function chooseWord($room,$dataProcessor){
        $sql = "select t.ID from DIC_WORD t where MODE = ? ORDER BY rand() limit 1;";
        $wordId = $dataProcessor -> chooseWord($sql,$room -> getDifficulty());
        return $wordId;
    }

    function choosePlayerToStart($room,$dataProcessor){
        $startId = random_int(1,$room -> getPlayerNum());
        $sql = "update TEMP_ROOM_" .$room -> getRoomId() ." set STATUS = 'A' where ID = ?;";
        $isSucc = $dataProcessor -> choosePlayerToStart($startId,$sql);
        return $isSucc;
    }

    function assignSpy($room,$dataProcessor){
        $spyId = random_int(1,$room -> getPlayerNum());
        $sql = "update TEMP_ROOM_" .$room -> getRoomId() ." set IS_SPY = 'S' where ID = ?;";
        //$sqlQ = "select PLAYER from TEMP_ROOM_" .$room -> getRoomId() ." where ID = ?;";
        $isSucc = $dataProcessor -> setSpy($sql,$spyId);
        return $isSucc;
    }

    function isStart($roomId){
        $sql = "select t.STATUS, t.WORD_ID from T_ROOM_MDL t where t.ID = ?;";
        $dataProcessor = new DataProcessor();
        $res = $dataProcessor -> getRoomStatus($sql,$roomId);
        if($res["status"] == "D"){
            $sql = "select t.FIRSTWORD,t.SECONDWORD from DIC_WORD t where t.ID = ?;";
            $words = $dataProcessor -> getWords($sql,$res["other"]);
            array_push($res,$words);
        }
        $dataProcessor -> conn_close();
        return $res;
    }

    function amISpy($roomId,$userId){
        $sql = "select t.IS_SPY from TEMP_ROOM_" .$roomId ." t where t.PLAYER = ?";
        $dataProcessor = new DataProcessor();
        $isSpy = $dataProcessor -> amISpy($sql,$userId);
        $dataProcessor -> conn_close();
        return $isSpy;
    }
}