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

class DataProcessor{
    private $conn;
    private $dbName = "spy_dev";
    private $host = "127.0.0.1";
    private $username = "spy_dev";
    private $password = "thespy";

    public function __construct()
    {
        $this -> conn = new Mysqli($this -> host,$this -> username,$this -> password,$this -> dbName);
        if($this  -> conn -> connect_error){
            die("fail to connect".$this -> conn -> connect_error);
        }

        $this -> conn -> query("set names utf8");
    }

    public function execute_dql($sql){

        $res = $this -> conn -> query($sql) or die ("sql".$this -> conn -> error);

        return $res;
    }

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

    public function joinGame($sql,$roomId,$userId){

        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("si",$userId,$roomId);
        $sql_stmt -> execute();
        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

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


    public function getEmp($startNo,$pageSize,$sql){

        $sql_stmt = $this -> conn -> prepare($sql);

        $sql_stmt -> bind_param("ii",$startNo,$pageSize);


        $sql_stmt->execute();

        $meta = $sql_stmt->result_metadata();
        while ($field = $meta->fetch_field())
        {
            $params[] = &$row[$field->name];
        }

        call_user_func_array(array($sql_stmt, 'bind_result'), $params);


        $counter = 0;
        while($sql_stmt -> fetch()){
            $i = 0;
            foreach ($row as $key => $val){
                $empInfoList[$i] = $val;
                $i ++;
            }
            $employee = new Employee($empInfoList[0],$empInfoList[1],$empInfoList[2],$empInfoList[3],$empInfoList[4]);
            $empList[$counter] = $employee;
            $counter ++;
        }
        $sql_stmt->close();

        return $empList;

    }

    public function deleteEmp($emp_id,$sql){

        $sql_stmt = $this -> conn -> prepare($sql);
        $sql_stmt -> bind_param("s",$emp_id);
        $sql_stmt -> execute();

        $isSucc = $sql_stmt -> affected_rows;

        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;


    }

    public function addEmp($employee,$sql){
        $sql_stmt = $this -> conn -> prepare($sql);

        $empName = $employee -> getEmpName();
        $empLevel = $employee -> getEmpLevel();
        $email = $employee -> getEmail();
        $salary = $employee -> getSalary();

        $sql_stmt -> bind_param("ssss",$empName,$empLevel,$email,$salary);
        $sql_stmt -> execute();

        $isSucc = $sql_stmt -> affected_rows;
        $sql_stmt -> free_result();
        $sql_stmt -> close();
        return $isSucc;
    }

    public function getEmpInfo($empId,$sql){
        $sql_stmt = $this -> conn -> prepare($sql);

        $sql_stmt -> bind_param("s",$empId);
        $sql_stmt -> bind_result($empName,$empLevel,$email,$salary);
        $sql_stmt -> execute();
        while($sql_stmt -> fetch()){
            $employee = new Employee($empId,$empName,$empLevel,$email,$salary);
            $sql_stmt -> free_result();
            $sql_stmt -> close();
            return $employee;
        }

    }

    public function editEmpInfo($employee,$sql){
        $sql_stmt = $this -> conn -> prepare($sql);
        $empId = $employee -> getEmpId();
        $empName = $employee -> getEmpName();
        $empLevel = $employee -> getEmpLevel();
        $email = $employee -> getEmail();
        $salary = $employee -> getSalary();

        $sql_stmt -> bind_param("sssss",$empName,$empLevel,$email,$salary,$empId);
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