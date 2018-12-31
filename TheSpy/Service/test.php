<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 12/29/2018
 * Time: 8:26 PM
 * Version:
 * Description:
 */
require_once '../DAO/DataProcessor.class.php';

$sql = "select t.PLAYER,t.IS_SPY,t.VOTE from TEMP_ROOM_52 t order by t.VOTE desc limit 2;";
$dataProcessor = new DataProcessor();
$res = $dataProcessor -> execute_dql($sql);
while($dead = $res ->fetch_row()){
    print_r($dead);
}

?>