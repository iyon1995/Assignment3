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
require_once '../Entity/Message.class.php';

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
        $startId = $this -> isAbleToTalk($dataProcessor,$room -> getRoomId(),$startId,"O");
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

    function canISpeak($roomId,$userId){
        $sql = "select t.STATUS from TEMP_ROOM_" .$roomId ." t where t.PLAYER = ?";
        $dataProcessor = new DataProcessor();
        $canTalk = $dataProcessor -> canISpeak($sql,$userId);
        $dataProcessor -> conn_close();
        return $canTalk;
    }

    /**
     * send message
     * @param $roomId
     * @param $userId
     * @param $players
     * @param $content
     * @return int
     */
    function sendMessage($roomId,$userId,$players,$content){
        $sql = "insert into ROOM_MESSAGE (ROOM_ID,SENDER,RECEIVER,MESSAGE,IS_READ,SEND_TIME) values (?,?,?,?,'U',now());";
        $dataProcessor = new DataProcessor();
        foreach ($players as $key => $val) {
            if($userId != $val){
                $isSucc = $dataProcessor -> sendMess($sql,$roomId,$userId,$val,$content);
            }
        }
        $sql = "update TEMP_ROOM_" .$roomId ." set STATUS = 'F' where PLAYER = ?;";
        $dataProcessor -> alreadyTalked($sql,$userId);
        /*$sql = "select t.ID from TEMP_ROOM_" .$roomId ." t where PLAYER = ?;";
        $id = $dataProcessor -> getPlayerId($sql,$userId);
        $sql = "select max(t.ID) from TEMP_ROOM_" .$roomId ." t";
        $res = $dataProcessor -> execute_dql($sql);
        $maxId = $res -> fetch_row()[0];
        $res -> free();
        if($maxId == $id){
            $id = 1;
        }else{
            $id++;
        }*/
        $id = $this -> isAbleToTalk($dataProcessor,$roomId,$userId,"N");
        $sql = "update TEMP_ROOM_" .$roomId ." set STATUS = 'A' where ID = ? and STATUS = 'N';";
        $dataProcessor -> nextPlayer($sql,$id);
        $sql = "select count(t.ID) from TEMP_ROOM_" .$roomId ." t where t.STATUS = 'A' or t.STATUS = 'N';";
        $res = $dataProcessor -> execute_dql($sql);
        $count = $res -> fetch_row()[0];
        $res -> free();
        if($count == 0){
            $sql = "update T_ROOM_MDL set STATUS = 'V' where ID = ?";
            $dataProcessor -> startVote($sql,$roomId);
        }
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    function isAbleToTalk($dataProcessor,$roomId,$userId,$flag){
        $sql = "select t.ID,t.STATUS from TEMP_ROOM_" .$roomId ." t where t.PLAYER = ? or ID = ?;";
        $info = $dataProcessor -> getPlayerId($sql,$userId);
        $sql = "select max(t.ID) from TEMP_ROOM_" .$roomId ." t";
        $res = $dataProcessor -> execute_dql($sql);
        $maxId = $res -> fetch_row()[0];
        $res -> free();
        if($flag == "O"){
            if($info["status"] == "D"){
                if($maxId == $info["id"]){
                    $id = 1;
                }else{
                    $id = $info["id"] + 1;
                }
            }else{
                $id = $info["id"];
            }
        }else{
            if($maxId == $info["id"]){
                $id = 1;
            }else{
                $id = $info["id"] + 1;
            }
            $id = $this -> isAbleToTalk($dataProcessor,$roomId,$id,"O");
        }
        return $id;
    }

    function getMessage($roomId,$userId){
        $sql = "select t.ID,t.SENDER,t.MESSAGE,t.SEND_TIME from ROOM_MESSAGE t ";
        $sql .= "where t.ROOM_ID = ? and t.RECEIVER = ? and t.IS_READ = 'U';";
        $dataProcessor = new DataProcessor();
        $mess = $dataProcessor -> getMess($sql,$roomId,$userId);
        foreach ($mess as $key => $val){
            $sql = "update ROOM_MESSAGE set IS_READ = 'R' where ID = ?;";
            $isSucc = $dataProcessor -> isRead($sql,$val -> getMessId());
        }
        $dataProcessor -> conn_close();
        return $mess;
    }

    function canVote($roomId){
        $sql = "select t.STATUS from T_ROOM_MDL t where t.ID = ?;";
        $dataProcessor = new DataProcessor();
        $status= $dataProcessor -> canVote($sql,$roomId);
        $dataProcessor -> conn_close();
        return $status;
    }

    function vote($roomId,$userId,$candidate){

        $sql = "update TEMP_ROOM_" .$roomId. " set VOTE = VOTE + 1 where PLAYER = ?;";
        $dataProcessor = new DataProcessor();
        $isSucc = $dataProcessor -> vote($sql,$candidate);
        if($isSucc != 0){
            $sql = "update TEMP_ROOM_" .$roomId. " set STATUS = 'V' where PLAYER = ?;";
            $isSucc= $dataProcessor -> setVoted($sql,$userId);
        }
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    function getResult($roomId){
        $sql = "select t.RESULT from T_ROOM_MDL t where t.ID = ? and STATUS != 'V';";
        $dataProcessor = new DataProcessor();
        $result= $dataProcessor -> getResult($sql,$roomId);
        $dataProcessor -> conn_close();
        return $result;

    }

    function checkAllVoted($roomId){
        $sql = "select count(t.PLAYER) from TEMP_ROOM_" .$roomId. " t where STATUS != 'V' and t.STATUS != 'D';";
        $dataProcessor = new DataProcessor();
        $res = $dataProcessor -> execute_dql($sql);
        $count = $res -> fetch_row()[0];
        $res -> free();
        return $count;
    }

    function checkDead($roomId){
        $sql = "select t.PLAYER,t.IS_SPY,t.VOTE from TEMP_ROOM_" .$roomId. " t order by t.VOTE desc limit 2;";
        $dataProcessor = new DataProcessor();
        $res = $dataProcessor -> execute_dql($sql);
        $mortuary = array();
        while($dead = $res ->fetch_row()){
            array_push($mortuary,$dead);
        }
        $res -> free();
        if($mortuary[0][2] == $mortuary[1][2]){
            $dead = array("NONE","",$mortuary[0][2]);
            array_push($mortuary,$dead);
        }else{
            array_push($mortuary,$mortuary[0]);
        }
        return $mortuary[2];
    }

    function setDead($playerId,$roomId){
        $sql = "update TEMP_ROOM_" .$roomId. " set STATUS = 'N',VOTE = 0 where STATUS != 'D'";
        $dataProcessor = new DataProcessor();
        $isSucc = $dataProcessor -> execute_dml($sql);
        if($playerId != "NONE"){
            $sql = "update TEMP_ROOM_" .$roomId. " set STATUS = 'D' where PLAYER = ?";
            $isSucc = $dataProcessor -> setDead($sql,$playerId);
        }
        $dataProcessor -> conn_close();
        return $isSucc;
    }

    function checkResult($roomId){
        $aLive = array();
        $dataProcessor = new DataProcessor();
        $sql = "select count(t.ID) from TEMP_ROOM_" .$roomId. " t where IS_SPY = 'S' and t.STATUS != 'D';";
        $res = $dataProcessor -> execute_dql($sql);
        $count = $res -> fetch_row()[0];
        array_push($aLive,$count);
        //$res -> free();
        $sql = "select count(t.ID) from TEMP_ROOM_" .$roomId. " t where t.STATUS != 'D';";
        $res = $dataProcessor -> execute_dql($sql);
        $count = $res -> fetch_row()[0];
        array_push($aLive,$count);
        $res -> free();
        $dataProcessor -> conn_close();
        return $aLive;
    }

    function setResult($roomId,$result,$status){
        $sql = "update T_ROOM_MDL set STATUS = ? ,RESULT = ? where ID = ?";
        $dataProcessor = new DataProcessor();
        $isSucc = $dataProcessor -> setResult($sql,$roomId,$result,$status);
        return $isSucc;
    }

    function nextRound($room){
        $dataProcessor = new DataProcessor();
        $isSucc = $this -> choosePlayerToStart($room,$dataProcessor);
        $dataProcessor -> conn_close();
        return $isSucc;
    }
}