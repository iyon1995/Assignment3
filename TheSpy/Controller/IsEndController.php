<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/2/2019
 * Time: 10:36 PM
 * Version: 1.0
 * Description: For user to ask if the game is finished
 */

require_once '../Service/RoomService.class.php';
require_once '../tools/PhpValidate.php';


if(!empty($_POST['roomId'])){
    $roomId = $_POST['roomId'];
    $roomId = checkSpecialChar($roomId);
}

$roomService = new RoomService();
$status = $roomService -> isEnd($roomId);

echo '{"status":"' . $status . '"}';


?>