<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 9/17/2018
 * Time: 7:39 PM
 * Version:
 * Description:
 */

require_once '../Entity/User.class.php';
require_once '../Entity/Room.class.php';
require_once '../Entity/Message.class.php';

class DataProcessor{
    private $conn;
    private $dbName = "spy_test";
    private $host = "127.0.0.1";
    private $username = "spy_test";
    private $password = "thespy";

    public function __construct()
    {
        $this -> conn = new Mysqli($this -> host,$this -> username,$this -> password,$this -> dbName);
        if($this  -> conn -> connect_error){
            die("fail to connect".$this -> conn -> connect_error);
        }

        $this -> conn -> query("set names utf8");
    }

    /**
     * Execute query sql without param
     * @param $sql
     * @return bool|mysqli_result
     */
    public function execute_dql($sql){

        $res = $this -> conn -> query($sql) or die ("sql".$this -> conn -> error);

        return $res;
    }

    /**
     * Execute insert update delete drop create sql without param
     * @param $sql
     * @return string
     */
    public function execute_dml($sql){
        $res = $this -> conn -> query($sql) or die ("sql".$this -> conn -> error);

        if(!$res){
            return "f";
        }else {
            if($this -> conn -> affected_rows > 0){
                return "s";
            }else {
                return "u";
            }
        }

    }

    /**
     * Check user login
     * @param $sql
     * @param $user
     * @return mixed
     */
    public function checkLogin($sql,$user){
        $sql_stmt = $this -> conn -> prepare($sql);
        $id = $user -> getUserId();
        $sql_stmt -> bind_param("s",$id);

        $sql_stmt -> bind_result($res_password);

        $sql_stmt -> execute();


        while($sql_stmt -> fetch()){
            $password = $res_password;
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $password;
        }


    }


    /**
     * Register user an account
     * @param $sql
     * @param $user
     * @return int
     */
    public function register($sql,$user){
        $sql_stmt = $this -> conn -> prepare($sql);
        $userId = $user -> getUserId();
        $userName = $user -> getUserName();
        $password = $user -> getPassword();
        $staus = $user -> getStatus();
        $sql_stmt -> bind_param("ssss",$userId,$userName,$password,$staus);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }


    /**
     * Assign a empty room or new room to User
     * @param $sql
     * @param $room
     * @return int
     */
    public function generateRoom($sql,$room){

        $sql_stmt = $this -> conn -> prepare($sql);
        $roomId = $room -> getRoomId();
        $roomType = $room ->getRoomType();
        $playerNum = $room -> getPlayerNum();
        $isRreveal = $room -> getisRreveal();
        $difficulty = $room -> getDifficulty();
        $password = $room -> getPassword();
        $status = $room -> getStatus();
        $owner = $room -> getOwner();
        if($roomId == ""){
            $sql_stmt -> bind_param("sisssss",$roomType,$playerNum,$isRreveal,$difficulty,$password,$status,$owner);
        }else{
            $sql_stmt -> bind_param("sisssssi",$roomType,$playerNum,$isRreveal,$difficulty,$password,$status,$owner,$roomId);
        }

        $sql_stmt -> execute();

        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    /**
     * Get information of room
     * @param $sql
     * @param $getRoomInfoBy
     * @return Room
     */
    public function getRoomInfo($sql,$getRoomInfoBy){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("si",$getRoomInfoBy,$getRoomInfoBy);
        $sql_stmt -> bind_result($roomId,$roomType,$playerNum,$isRreveal,$difficulty,$password,$status,$owner);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $room = new Room($roomId,$roomType,$playerNum,$isRreveal,$difficulty,$password,$status,$owner);
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $room;
        }

    }

    /**
     * Search room by id
     * @param $sql
     * @param $roomId
     * @return Room
     */
    public function searchRoom($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> bind_result($roomId,$password);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $room = new Room($roomId,$password);
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $room;
        }

    }

    /**
     * Check whether the room is full
     * @param $sqlM
     * @param $sqlC
     * @param $roomId
     * @return int
     */
    public function isFull($sqlM,$sqlC,$roomId){
        $sql_stmt = $this -> conn -> prepare($sqlM);
        $sql_stmt -> bind_param("s",$roomId);
        $sql_stmt -> bind_result($playerNum);
        $sql_stmt->execute();
        $diff = 0;
        while($sql_stmt -> fetch()){
            $diff += $playerNum;
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();

        $sql_stmt = $this -> conn -> prepare($sqlC);
        $sql_stmt -> bind_result($num);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $diff -= $num;
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();

        return $diff;
    }

    /**
     * Join in the game
     * @param $sql
     * @param $roomId
     * @param $userId
     * @return int
     */
    public function joinGame($sql,$roomId,$userId){

        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("si",$userId,$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    /**
     * Get players id of a room
     * @param $sql
     * @return array
     */
    public function getPlayers($sql){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_result($playerId);
        $sql_stmt->execute();
        $players = array();
        while($sql_stmt -> fetch()){
            array_push($players,$playerId);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $players;
    }

    /**
     * Get a pair of word by id
     * @param $sql
     * @param $wordId
     * @return array
     */
    public function getWords($sql,$wordId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$wordId);
        $sql_stmt -> bind_result($nWord,$sWord);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            /**
             * N => normal, S => spy
             */
            $words = array("N" => $nWord,"S" => $sWord);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $words;
    }

    /**
     * Get a pair of word from dictionary
     * @param $sql
     * @param $difficulty
     * @return mixed
     */
    public function chooseWord($sql,$difficulty){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$difficulty);
        $sql_stmt -> bind_result($ID);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $wordId = $ID;
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $wordId;
    }

    /**
     * Assign spy to a user
     * @param $sql
     * @param $spyId
     * @return int
     */
    public function setSpy($sql,$spyId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$spyId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    /**
     * Set game flag as "S" start
     * @param $sql
     * @param $roomId
     * @param $wordId
     * @return int
     */
    public function iniGame($sql,$roomId,$wordId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("ii",$wordId,$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    /**
     * Choose a player to start to speak
     * @param $startId
     * @param $sql
     * @return int
     */
    function choosePlayerToStart($startId,$sql){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$startId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    /**
     * Get status of a room
     * @param $sql
     * @param $roomId
     * @return array
     */
    function getRoomStatus($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> bind_result($status,$result);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $res = array("status" => $status,"other" => $result);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $res;
    }


    /**
     * For players to ask if himself is dead
     * @param $sql
     * @param $userId
     * @return mixed
     */
    function amISpy($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> bind_result($isSpy);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $isSpy;
        }
    }

    function uniqueEmail($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> bind_result($id);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $id;
        }
    }

    /**
     * For players to ask if himself is dead
     * @param $sql
     * @param $userId
     * @return mixed
     */
    function canISpeak($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> bind_result($canTalk);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $canTalk;
        }
    }

    function alreadyTalked($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    function getPlayerId($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("si",$userId,$userId);
        $sql_stmt -> bind_result($id,$status);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $info = array("id" => $id,"status" => $status);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $info;
    }

    function getPlayersInfo($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> bind_result($userName,$level,$gRound,$gwRound,$gwsRound);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $user = new User($userId,$userName,$level,$gRound,$gwRound,$gwsRound);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $user;
    }

    function sendMess($sql,$roomId,$sender,$receiver,$content){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("isss",$roomId,$sender,$receiver,$content);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    function nextPlayer($sql,$id){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$id);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    function startVote($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    function getMess($sql,$roomId,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("is",$roomId,$userId);
        $sql_stmt -> bind_result($messId,$sender,$content,$sendTime);
        $sql_stmt->execute();
        $messages = array();
        while($sql_stmt -> fetch()){
            $message = new Message($messId, $roomId, $sender, $userId, $content, $sendTime);
            array_push($messages,$message);
        }
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $messages;
    }

    function isRead($sql,$messId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$messId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function canVote($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> bind_result($canVote);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $canVote;
        }
    }

    public function vote($sql,$candidate){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$candidate);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function setVoted($sql,$userId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$userId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function getResult($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> bind_result($result);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $result;
        }

    }

    public function setDead($sql,$playerId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$playerId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function setResult($sql,$roomId,$result,$status){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("ssi",$status,$result,$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }


    public function settleExp($sql,$userId,$exp){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("is",$exp,$userId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function settleAccounts($sql,$userId,$exp,$result){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("iiis",$exp,$result['isWin'],$result['isSpyWin'],$userId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function isEnd($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> bind_result($status);
        $sql_stmt->execute();
        while($sql_stmt -> fetch()){
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $status;
        }
    }

    public function ownerLeftRoom($sql,$roomId){
        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("i",$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }


    public function conn_close(){
        if (!empty($this->conn)) {
            $this -> conn -> close();
        }
    }
}
?>