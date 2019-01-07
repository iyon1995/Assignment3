<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 9/22/2018
 * Time: 4:08 PM
 * Version:
 * Description:
 */
    function getLastLogin(){
        if (!empty($_COOKIE['lastVisit'])) {
            echo "last visit at: " .$_COOKIE['lastVisit'];
            setcookie("lastVisit",date("Y-m-d H:i:s"),time() + (24 * 30 * 3600));
        } else{
            echo "first visit!!";
            setcookie("lastVisit",date("Y-m-d H:i:s"),time() + (24 * 30 * 3600));
        }
    }

    function setLogin($userId){
        setcookie("userId",$userId,time() + (24 * 30 * 3600));
    }


    function setOwner($userId){
        setcookie("owner",$userId,time() + (24 * 30 * 3600));
    }

    function joinInRoom(){
        setcookie("isJoin","T",time() + (24 * 30 * 3600));
    }

    function setTurn($turn){
        setcookie("turn",$turn,time() + (24 * 30 * 3600));
    }

    function setExp($operateTpye){
        if($operateTpye == "i"){
            setcookie("exp",1,time() + (24 * 30 * 3600));
        }else if($operateTpye == "w"){
            $exp = getCookieVal("exp");
            $exp += 3;
            setcookie("exp",$exp,time() + (24 * 30 * 3600));
        }else if($operateTpye == "l"){
            $exp = getCookieVal("exp");
            $exp += 1;
            setcookie("exp",$exp,time() + (24 * 30 * 3600));
        }else if($operateTpye == "p"){
            $exp = getCookieVal("exp");
            $exp -= 2;
            setcookie("exp",$exp,time() + (24 * 30 * 3600));
        }else if($operateTpye == "c"){
            setcookie("exp",0,time() + (24 * 30 * 3600));
        }
    }

    function delCookie($key){
        setcookie($key,"",time() - (24 * 30 * 3600));
    }

    function getCookieVal($key){
        if(!empty($_COOKIE[$key])){
            return $_COOKIE[$key];
        }else {
            return "";
        }
    }
?>