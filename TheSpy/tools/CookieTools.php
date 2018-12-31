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

    function getCookieVal($key){
        if(!empty($_COOKIE[$key])){
            return $_COOKIE[$key];
        }else {
            return "";
        }
    }
?>