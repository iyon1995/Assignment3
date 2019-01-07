<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/2/2019
 * Time: 10:36 PM
 * Version:
 * Description:
 */

require_once '../Service/RoomService.class.php';


if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
}

$roomService = new RoomService();
$status = $roomService -> isEnd($roomId);

echo '{"status":"' . $status . '"}';


?>