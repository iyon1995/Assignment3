<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 9/23/2018
 * Time: 8:40 PM
 * Version:
 * Description:
 */
function setLogInInfo($userName){
    session_start();
    $_SESSION['LoginInfo'] = $userName;
}


function getLogInInfo(){
    if(session_status() !== PHP_SESSION_ACTIVE){
        session_start();
    }
    return $_SESSION['LoginInfo'];
}

function isLegelUser(){
    session_start();
    echo SID;
    if(empty($_SESSION['LoginInfo'])){
        header("Location: Login.php?errno=2");
        exit();
    }
}

?>