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

for ($i = 46; $i <= 83; $i++) {
    echo "drop table TEMP_ROOM_" . $i . ";<br/>";
}

?>